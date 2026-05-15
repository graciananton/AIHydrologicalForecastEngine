# load modules
from openai import OpenAI
from dotenv import load_dotenv
import os, time
from pprint import pprint
import time
import json

load_dotenv()

client = OpenAI(
    api_key=os.environ["OPENAI_API_KEY"]
)

print("Finished process 1")

# creates a vector store and assigns a name
vector_store = client.vector_stores.create(
    name="AI Hydrological Forecasting Engine"
)
print(vector_store.id)

# uploads file to vector store by giving vector_store_id and file
file = client.vector_stores.files.upload(
    vector_store_id = vector_store.id,
    file = open("ai_hydrological_forecast_engine_test_knowledge.txt","rb")
)
# runs until the file is uploaded by retrieving the file and checking status
# if file status == "completed" => breaks out of loop
while True:
    status = client.vector_stores.files.retrieve(
        vector_store_id = vector_store.id,
        file_id = file.id
    )
    time.sleep(2)
    if status.status == "completed":
        break
print("Finished process 2")

# updates vector store with new name
client.vector_stores.update(
    vector_store_id = vector_store.id,
    name = "AI-Driven Hydrological Monitoring and Forecast Engine"
)
# updates file meta-attributes
file = client.vector_stores.files.update(
    vector_store_id = vector_store.id,
    file_id = file.id,
    attributes = {
        "department": "Hydrology",
        "version":"v2"
    }
)


print("Finished process 3")

response = client.responses.create(
    model="ft:gpt-4.1-nano-2025-04-14:personal::DBnrOY4u",
    input="What does the system say about flood prediction?",
    tools=[{
        "type": "file_search",
        "vector_store_ids": [vector_store.id]
    }]
)

print(response.output)

