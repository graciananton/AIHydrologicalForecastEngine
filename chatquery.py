import requests
from openai import OpenAI
from dotenv import load_dotenv
import os
import json
from pprint import pprint
load_dotenv()

class ChatQuery():      
    def __init__(self):
        self.initialize_model()
        self.filters()
        self.tools()

    def initialize_model(self):
        self.client = OpenAI(
            api_key=os.environ["OPENAI_API_KEY"]
        )
    def tools(self):
        self.tools = [
            # each of these are functions
            {
                "type": "function",
                "name": "send_otp",
                "description": "This function sends the otp verification code to the user using the email address",
                "parameters": {
                    "type": "object",
                    "properties": {
                        "email_address": {
                            "type": "string",
                            "description": "user email address input",
                        },
                    },
                    "required": ["email_address"]
                },
            },
            {
                "type": "function",
                "name": "verify_otp",
                "description": "This function verifies the otp verification code using the verification code the user submitted",
                "parameters": {
                    "type": "object",
                    "properties": {
                        "verification_code": {
                            "type": "string",
                            "description": "user verification code input",
                        },
                    },
                    "required": ["verification_code"]
                },
            },
            {
                # this uses the .search() function to return a chunk with a similarity score
                "type":"file_search",
                "vector_store_ids":['vs_69babea6537c8191b5040e4b60b13ae1'],
                "filters":self.filters,
                "max_num_results": 3,
                "ranking_options": {
                    "score_threshold": 0.5
                },
            }
        ]

    def generate_response(self, query):
        messages = [
            {"role": "user", "content": query}
        ]

        while True:
            if query == "exit":
                break

            response = self.client.responses.create(
                model="gpt-4.1",
                tools=self.tools,
                input=messages
            )

            if response.output[0].type == "function_call":
                messages.append({
                    "type":response.output[0].type,
                    "name":response.output[0].name,
                    "arguments":response.output[0].arguments
                })
            elif response.output[0].type == "message":
                messages.append({
                    "type":response.output[0].type,
                    "role":"assistant",
                    "content":response.output[0].content[0].text
                })
    
            if response.output[0].type == "function_call":
                for item in messages:
                    if item.name == "send_otp":
                            data = json.loads(item.arguments)
                            result = self.send_otp(data)

                    elif item.name == "verify_otp":
                            data = json.loads(item.arguments)
                            data['id'] = self.id
                            result = self.verify_otp(data)
                        
                    messages.append({
                            "type": "function_call_output",
                            "call_id": item.call_id,
                            "output": str(result)
                    })

                    response = self.client.responses.create(
                        model="gpt-4.1",
                        tools=self.tools,
                        input=messages[-1]['output']
                    )

                    messages.append({
                        "type":"message",
                        "role": "assistant",
                        "content": response.output_text
                    })
        
            pprint(messages)

            query = input("->")
            messages.append({"role": "user", "content": query})




    def send_otp(self,data:dict)->str:
        url="http://localhost/laravel/public/api/request_otp"

        print(data)
        response = requests.post(url,json = data).json()

        self.id = response['id']

        if response['success'] == True:
            return f"Your verification code was sent to . Enter the verification code here (expires: 5 minutes sec.)"
        else:
            return f"Your verification code was not sent to. Re-enter correct email address"
        

    def verify_otp(self,data:dict)->str:
        url="http://localhost/laravel/public/api/request_verify_otp"

        response = requests.post(url, json=data).json()

        if response['success'] == True:
            return f"Account successfully created."
        else:
            return f"Account unsuccessfully created."


    def filters(self):
        self.filters = {
            "type": "or",
            "filters": [
                {
                    "type": "eq",
                    "key": "version",
                    "value": "v2"
                },
                {
                    "type": "eq",
                    "key": "department",
                    "value": "Hydrology"
                }
            ]
        }

if __name__ == "__main__":
    #query = "My email address is basil_anton@yahoo.ca"
    query = "What is this system about"
    chatQuery = ChatQuery()

    chatQuery.generate_response(query)
 
