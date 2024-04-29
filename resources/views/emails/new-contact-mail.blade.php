<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BoolBnB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <section class="row justify-content-center">
            <div class="col-7 p-5">
                <h1>
                    You have a new lead!
                </h1>
                <h2>
                    {{ $lead->name }} sent you this message, this day: {{ $lead->date }}, on this email: {{ $lead->email }}
                </h2>
                <p>
                    Email content: {{ $lead->message }}.
                </p>
            </div>
        </section>
    </main>
    
</body>
</html>