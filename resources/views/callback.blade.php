<html>
<head>
    <meta charset="utf-8">
    <title>Callback</title>
    <script>
        window.opener.postMessage({token: "{{ $token }}"}, "{{url('/')}}");
        window.close();
    </script>
</head>
<body>
</body>
</html>
