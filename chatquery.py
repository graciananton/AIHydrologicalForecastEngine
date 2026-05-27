import requests
from openai import OpenAI
from dotenv import load_dotenv
import os
import json
from pprint import pprint
from bs4 import BeautifulSoup

load_dotenv()

class ChatQuery(): 
    def __init__(self):
        self.initialize_model()
        self.filters()
        self.tools()
        self.session = None

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
                        "email": {
                            "type": "string",
                            "description": "user email address input",
                        }
                    },
                    "required": ["email"]
                },
            },
            {
                "type": "function",
                "name": "verify_otp",
                "description": "This function verifies the otp verification code using the verification code the user submitted",
                "parameters": {
                    "type": "object",
                    "properties": {
                        "verificationCode": {
                            "type": "string",
                            "description": "user verification code input",
                        },
                    },
                    "required": ["verification_code"]
                },
            },
            {
                # this uses the .search() function to return a chunk with a similarity score
                "type": "file_search",
                "vector_store_ids":['vs_6a0726dda1588191bcb83beebd316d5a'],
                "filters":self.filters,
                "max_num_results": 1,
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
            tool_calls = [
                item for item in response.output
                if item.type == "function_call"
            ]

            messages_output = [
                item for item in response.output
                if item.type == "message"
            ]

            tool_outputs = []
        
            for item in tool_calls:
                if item.name == "send_otp":
                    data = json.loads(item.arguments)
                    data['accept'] = 'json'
                    result = self.send_otp(data)                        

                elif item.name == "verify_otp":
                    data = json.loads(item.arguments)
                    data['accept'] = 'json'
                    result = self.verify_otp(data)

                tool_outputs.append({
                    "type": "function_call_output",
                    "call_id": item.call_id,
                    "output": str(result)
                })

            if len(messages_output) > 0:
                messages.append({
                    "role": "assistant",
                    "content": messages_output[0].content[0].text
                })


            if len(tool_outputs) > 0:
                messages.append({
                    "role": "assistant",
                    "content": tool_outputs[0]['output']
                })

            pprint(messages[-1])

            query = input("->")
            messages.append({"role": "user", "content": query})


    def send_otp(self,data:dict)->str:
        self.session = requests.Session()

        response = self.session.get("http://localhost/laravel/public/login")

        soup = BeautifulSoup(response.text, "html.parser")

        csrf_token = soup.find(
            "meta",
            attrs={"name": "csrf-token"}
        )["content"]

        headers = {
            "X-CSRF-TOKEN": csrf_token,
            "Accept": "application/json"
        }

        response = self.session.post(
            "http://localhost/laravel/public/loginSubmit",
            headers=headers,
            json = data
        )
        response = response.json()

        if response['success'] == True and response['loggedIn'] == True:
            return f"You are logged in to system, to access your dashboard, click here: http://localhost/laravel/public/userStation"
        elif response['success'] == True and response['loggedIn'] == False:
            return f"Your verification code was sent, enter it below"
        else:
            return f"Verification Code unsuccessfully sent, enter email address again below."


    def verify_otp(self,data:dict)->str:
        if self.session == None:
            return "You have not sent your email address yet, send email address then we can send a verification code"
    
        response = self.session.get("http://localhost/laravel/public/verificationCode")

        soup = BeautifulSoup(response.text, "html.parser")

        csrf_token = soup.find(
            "meta",
            attrs={"name": "csrf-token"}
        )["content"]

        headers = {
            "X-CSRF-TOKEN": csrf_token,
            "Accept": "application/json"
        }
        response = self.session.post(
            "http://localhost/laravel/public/verificationCodeSubmit",
            headers=headers,
            json = data
        )
        print(response.status_code)
        print(response.text)

        response = response.json()

        if response['success']:
            return "Your account has been created, to access it, click http://localhost/laravel/public/userStation"
        else:
            return "Your account has not been created, to verify, re-enter your email address"

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
    query = input("->")
    chatQuery = ChatQuery()

    chatQuery.generate_response(query)
 
