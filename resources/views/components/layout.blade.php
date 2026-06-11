<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'TeamManager' }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans">

  <!-- Include the nav-bar -->
  @include('components.nav-bar')

  {{ $slot }}

  <!-- Include the footer -->
  @include('footer')

</body>
</html>
