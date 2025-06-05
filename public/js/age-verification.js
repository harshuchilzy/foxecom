document.addEventListener('alpine:init', () => {
  Alpine.data('foxecomAgeVerification', () => ({
    country: 'uk',
    day: '',
    month: '',
    year: '',
    errorMessage: '',
    showPopup: false,
    
    init() {
        if (this.getCookie('birthday') && this.getCookie('country')) {
            this.showPopup = false;
            //console.log('Cookies found, popup not shown');
        } else {
            this.showPopup = true;
            //console.log('No cookies found, popup shown');
        }
    },
    
    foxecomVerifyAge() {
 
        this.errorMessage = '';
      
        if (!this.day || !this.month || !this.year) {
            this.errorMessage = 'Please fill in all the fields';
            return;
        }
      
        const dayNum = parseInt(this.day);
        const monthNum = parseInt(this.month);
        const yearNum = parseInt(this.year);
      
        if (dayNum < 1 || dayNum > 31) {
            this.errorMessage = 'Day must be between 1-31';
            return;
        }
      
        if (monthNum < 1 || monthNum > 12) {
            this.errorMessage = 'Month must be between 1-12';
            return;
        }
      
        const currentYear = new Date().getFullYear();
        if (yearNum < 1900 || yearNum > currentYear) {
            this.errorMessage = `Year must be between 1900-${currentYear}`;
            return;
        }
      
        const birthDate = new Date(yearNum, monthNum - 1, dayNum);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
      
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        
        // Check if 18 or older
        if (age >= 18) {
            // Set cookies
            this.setCookie('birthday', `${dayNum}-${monthNum}-${yearNum}`, 365);
            this.setCookie('country', this.country, 365);
            this.showPopup = false;
        } else {
            this.errorMessage = 'You must be 18 or older to proceed';
        }
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