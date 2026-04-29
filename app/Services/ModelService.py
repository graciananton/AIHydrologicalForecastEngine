from fastapi import FastAPI
import numpy as np

app = FastAPI()

@app.get("/hello")
def predict(data: dict):
    print("Received")
    return {"hello":"world"}