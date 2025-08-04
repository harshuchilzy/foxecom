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