with open('storage/logs/laravel.log', "r") as f:
    lines = f.readlines()
    print(lines)
    """ 
    if len(lines) > 200000:
        for i in range(0,50000):
            lines[i] = ""
    """


        