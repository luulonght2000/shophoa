<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <table>
    <tr>
      <td>ID</td>
      <td>SL</td>
    </tr>
    {{-- @foreach ($sold as $value)
    <tr>
      <td>{{$value->id}}</td>
      <td>{{$value->sold}}</td>
    </tr>
    @endforeach --}}

    </tr>
    @foreach ($sold as $value)
    <tr>
      <td>{{$value->id}}</td>
      <td>{{$value->sold}}</td>
    </tr>
    @endforeach
  </table>
</body>
</html>