<div class="fixed inset-0 bg-black/60 flex items-center justify-center z-50">
  <div class="bg-[radial-gradient(209.04%_209.04%_at_49.6%_50.56%,#0B0E2D_0%,#242E93_100%)] text-white p-8 rounded-xl shadow-xl w-full max-w-md text-center space-y-6">
    <!-- Logo -->
    <div class="text-3xl font-bold tracking-wide">
      <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mx-auto mb-4 w-24 h-24">
    </div>

    <!-- Country dropdown -->
    <div>
      <select class="w-full bg-gray-900 text-white px-4 py-2 rounded border border-gray-700">
        <option>United Kingdom</option>
        <!-- Add other countries if needed -->
      </select>
    </div>

    <!-- Age Verification Text -->
    <div>
      <h2 class="text-xl font-semibold mb-2">Age Verification Required</h2>
      <p class="text-sm text-blue-300 underline leading-snug">
        Certain products contain nicotine, which is a highly addictive substance.
        Sales are restricted to individuals 18 years and older.
      </p>
    </div>

    <!-- Date of Birth -->
    <div class="flex justify-center gap-2">
      <input type="text" placeholder="DD" class="w-16 px-2 py-2 bg-gray-800 border border-gray-700 rounded text-white text-center" />
      <input type="text" placeholder="MM" class="w-16 px-2 py-2 bg-gray-800 border border-gray-700 rounded text-white text-center" />
      <input type="text" placeholder="YYYY" class="w-24 px-2 py-2 bg-gray-800 border border-gray-700 rounded text-white text-center" />
      <button class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-white font-semibold">ENTER</button>
    </div>

    <!-- Terms -->
    <p class="text-xs text-gray-400 mt-4">
      By entering this site, you agree to our Terms of Use and acknowledge that you have read and understood our Cookie Policy and Privacy Policy.
    </p>
  </div>
</div>
