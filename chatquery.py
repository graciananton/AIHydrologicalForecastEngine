import requests
from openai import OpenAI
from dotenv import load_dotenv
import os

load_dotenv()

client = OpenAI(
    api_key=os.environ["OPENAI_API_KEY"]
)

vector_stores = client.vector_stores.list()

for vs in vector_stores.data:
    print(vs.id, vs.name)

"""
tools = [
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
    }
]

def send_otp(email_address:str)->str:
    url="/laravel/public/send_otp"
    data = {
        "email_address":email_address
    }
    response = requests.post(url, data=data)

    if response:
        return f"Your verification code was sent to {email_address}. Enter the verification code here (expires: 30 sec.)"
    else:
        return f"Your verification code was not sent to {email_address}. Re-enter correct email address"

def verify_otp(verification_code:str)->str:
    url="/laravel/public/verify_otp"
    data = {
        "verification_code":verification_code
    }
    response = requests.post(url, data=data)

    if response:
        return f"Account successfully created."
    else:
        return f"Account unsuccessfully created."

"""