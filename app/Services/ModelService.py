from fastapi import FastAPI
import numpy as np

app = FastAPI()

@app.post("/predict")
def predict(data: dict):
    features = np.array(data["features"])
    result = features.sum()  # example

    return {"prediction": result}