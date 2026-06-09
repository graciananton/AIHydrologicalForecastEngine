with open('storage/logs/laravel.log', "r") as f:
    lines = f.readlines()
    if len(lines) > 20000:
        for i in range(0,5000):
            lines[i] = ""


        