<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Fekra | Notes App</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background-image: url('/images/background2.jpg');
      background-size: cover;
      background-position: center;
      animation: fadeIn 1.5s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .overlay {
      background-color: rgba(255, 255, 255, 0.85);
      padding: 2rem;
      border-radius: 1rem;
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center text-gray-800 font-sans">

  <div class="overlay text-center px-6 sm:px-10 md:px-20 max-w-xl">
    <!-- Language Switch Button -->
    <div class="flex justify-end mb-4">
      <button onclick="toggleLanguage()" class="text-sm px-4 py-1 border rounded hover:bg-gray-200 transition">
        العربية
      </button>
    </div>

    <!-- Logo -->
    <div class="mb-6">
      <span class="text-5xl font-extrabold text-blue-400 tracking-wide">Fekra</span>
      <p id="tagline" class="text-sm text-gray-600 mt-1">Write it. Keep it. Remember it.</p>
    </div>

    <!-- Description -->
    <p id="description" class="text-lg sm:text-xl text-gray-700 mb-6">
      Welcome to <strong>Fekra</strong> — your peaceful corner to capture ideas, thoughts, and memories.
    </p>

    <!-- Buttons -->
    <div class="flex justify-center gap-4">
      <a href="{{ route('login') }}" id="loginBtn" class="bg-white border border-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-100 transition">
        Login
      </a>
      <a href="{{ route('register') }}" id="registerBtn" class="bg-blue-400 text-white px-6 py-2 rounded-lg hover:bg-blue-500 transition">
        Register
      </a>
    </div>
  </div>

  <script>
    let isArabic = false;

    function toggleLanguage() {
      isArabic = !isArabic;
      document.querySelector("button").textContent = isArabic ? "English" : "العربية";
      document.getElementById("tagline").textContent = isArabic ? "اكتبها. احتفظ بها. تذكرها." : "Write it. Keep it. Remember it.";
      document.getElementById("description").innerHTML = isArabic
        ? 'مرحبا بك في <strong>فكرة</strong> — ركنك الهادئ لتدوين الأفكار والذكريات.'
        : 'Welcome to <strong>Fekra</strong> — your peaceful corner to capture ideas, thoughts, and memories.';
      document.getElementById("loginBtn").textContent = isArabic ? "تسجيل الدخول" : "Login";
      document.getElementById("registerBtn").textContent = isArabic ? "تسجيل" : "Register";
    }
  </script>
</body>
</html>
