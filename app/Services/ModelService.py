
from fastapi import FastAPI
import numpy as np

app = FastAPI()

@app.post("/hello")
def predict(data: dict):
    return {"hello":"world"}