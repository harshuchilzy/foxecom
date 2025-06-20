<div class="fixed inset-0 backdrop-blur-sm hidden items-center justify-center z-50" :class="{'hidden': !showPopup, 'flex': showPopup}" x-data="foxecomAgeVerification()" x-show="showPopup" x-init="init()">
  <div class="bg-[radial-gradient(209.04%_209.04%_at_49.6%_50.56%,#0B0E2D_0%,#242E93_100%)] text-white p-14 rounded-xl shadow-xl w-full  max-w-sm sm:max-w-md md:max-w-2xl h-[780px] lg:h-[672px]  text-center space-y-6" >
    <!-- Logo -->
    <div class="text-3xl font-bold tracking-wide mb-16">
      <img src="{{ asset('images/logo-on-age-verification.png') }}" alt="Logo" class="mx-auto w-[140px]">
    </div>

    <!-- Country dropdown -->
    <div class="mb-10">
      <select class="w-64 bg-input-black text-white px-4 py-2 rounded border border-input-border-gray" x-model="country">
        <option value="uk">United Kingdom</option>
        <option value="us">United Arab Emirates</option>
      </select>
    </div>

    <!-- Age Verification Text -->
    <div class="mb-6">
      <h2 class="text-4xl font-semibold mb-5 font-inter">Age Verification Required</h2>
      <p class="text-base font-semibold text-white font-inter mb-7">
        Certain products contain nicotine, which is a highly addictive substance. Sales are restricted to individuals 18 years and<br> older.
      </p>
      <p class="text-xs font-medium font-inter text-gray-400">
        By entering this site, you agree to our Terms of<br> Use and acknowledge that you have read and<br> understood our Cookie Policy and Privacy Policy.
      </p>
    </div>

    <!-- Date of Birth -->
    <div class="flex justify-center gap-2">
      <input type="number" placeholder="DD" class="w-23 h-14 px-2 py-2 bg-input-black border border-input-border-gray rounded text-[#FFFFF2] text-center font-inter font-normal text-xl" min="1" max="31" x-model="day" />
      <input type="number" placeholder="MM" class="w-23 h-14 px-2 py-2 bg-input-black border border-input-border-gray rounded text-[#FFFFF2] text-center font-inter font-normal text-xl" min="1" max="12" x-model="month" />
      <input type="number" placeholder="YYYY" class="w-36 px-2 py-2 bg-input-black border border-input-border-gray rounded text-[#FFFFF2] text-center font-inter font-normal text-xl" min="1900" x-model="year" />
      <button type="button" class="w-36 px-2 py-2 bg-input-black border border-input-border-gray rounded text-[#FFFFF280] text-center font-inter font-normal text-xl hover:bg-blue-600 hover:text-white cursor-pointer duration-200 transition" @click="foxecomVerifyAge()">ENTER</button>
    </div>

    <div class="error text-xs font-medium font-inter text-red-500 mt-2" x-text="errorMessage" x-show="errorMessage"></div>

  </div>
</div>
