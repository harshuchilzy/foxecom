<div class="fixed inset-0 backdrop-blur-sm hidden items-center justify-center z-50" :class="{'hidden': !showPopup, 'flex': showPopup}" x-data="foxecomAgeVerification()" x-show="showPopup" x-init="init()">
  <div class="bg-[radial-gradient(209.04%_209.04%_at_49.6%_50.56%,#0B0E2D_0%,#242E93_100%)] text-white p-14 rounded-xl shadow-xl w-full  max-w-sm sm:max-w-md md:max-w-2xl h-auto md:h-[780px] lg:h-[672px]  text-center space-y-6" >
    <!-- Logo -->
    <div class="text-3xl font-bold tracking-wide md:mb-16 mb-8">
      <img src="{{ asset('images/logo-on-age-verification.png') }}" alt="Logo" class="mx-auto md:w-[140px] w-[100px]">
    </div>

    <!-- Country dropdown -->
    <div class="mb-10">
      <select class="w-64 bg-input-black text-white px-4 py-2 rounded border border-input-border-gray" x-model="country">
        <option value="uk">United Kingdom</option>
        <option value="us">United Arab Emirates</option>
      </select>
    </div>

    <!-- Age Verification Text -->
    <div class="mb-10">
      <h2 class="md:text-4xl text-2xl font-semibold mb-5 font-inter">Age Verification Required</h2>
      <p class="md:text-base text-sm font-semibold text-white font-inter mb-7">
        Certain products contain nicotine, which is a highly addictive substance. Sales are restricted to individuals 18 years and<br> older.
      </p>
      <p class="md:text-xs text-[10px] font-medium font-inter text-gray-400">
        By entering this site, you agree to our Terms of<br> Use and acknowledge that you have read and<br> understood our Cookie Policy and Privacy Policy.
      </p>
    </div>

    <!-- Age verifications -->
    <div class="flex justify-center gap-4">
      <!-- Under 18 Button -->
      <button 
        type="button" 
        class="w-40 px-4 py-3 rounded-lg text-center font-inter font-medium md:text-lg text-sm
              bg-gray-800 border border-gray-600 text-gray-300
              hover:bg-red-600 hover:text-white hover:border-red-700
              focus:outline-none 
              active:bg-red-700 active:scale-95
              transition-all duration-200 ease-in-out
              shadow-md hover:shadow-lg cursor-pointer" 
        @click="foxecomAgeRestrict()">
        I'm under 18
      </button>
      
      <!-- Over 18 Button -->
      <button 
        type="button" 
        class="w-40 px-4 py-3 rounded-lg text-center font-inter font-medium md:text-lg text-sm
              bg-blue-900 border border-blue-700 text-blue-100
              hover:bg-green-600 hover:text-white hover:border-green-700
              focus:outline-none
              active:bg-green-700 active:scale-95
              transition-all duration-200 ease-in-out
              shadow-md hover:shadow-lg cursor-pointer" 
        @click="foxecomAgeVerified()">
        I'm over 18
      </button>
    </div>

    <div class="error text-xs font-medium font-inter text-red-500 mt-2" x-text="errorMessage" x-show="errorMessage"></div>

  </div>

  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.data('foxecomAgeVerification', () => ({
        country: 'uk',
        day: '',
        month: '',
        year: '',
        errorMessage: '',
        showPopup: false,
        
        init() {
            if (( this.getCookie('is_age_varified') == 'true' ) && this.getCookie('country')) {
                this.showPopup = false;
            } else {
                this.showPopup = true;
            }
        },
        

        foxecomAgeVerified() {

            this.errorMessage = '';

            if (this.getCookie('is_age_varified') == 'false') {
                this.errorMessage = 'We\'d love your recommendation once you\'re old enough!';
                return;
            }
        
            this.setCookie('country', this.country, 365);
            this.setCookie('is_age_varified', true, 365);

            this.showPopup = false;
        },

        foxecomAgeRestrict() {
            this.errorMessage = '';
            this.errorMessage = 'We\'d love your recommendation once you\'re old enough!';
            this.setCookie('is_age_varified', false, 365);
        },
        
        setCookie(name, value, days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            const expires = "expires=" + date.toUTCString();
            document.cookie = `${name}=${value};${expires};path=/`;
        },
            
        getCookie(name) {
            const cookieName = `${name}=`;
            const decodedCookie = decodeURIComponent(document.cookie);
            const cookieArray = decodedCookie.split(';');
            
            for(let i = 0; i < cookieArray.length; i++) {
                let cookie = cookieArray[i];
                while (cookie.charAt(0) === ' ') {
                cookie = cookie.substring(1);
                }
                if (cookie.indexOf(cookieName) === 0) {
                return cookie.substring(cookieName.length, cookie.length);
                }
            }
            return null;
        }

        }));
    });
  </script>
</div>
