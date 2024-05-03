// Check if the user has already agreed to the use of cookies
if (document.cookie.indexOf('cookieAgreed=true') === -1) {
    // If the user has not agreed, prompt the user
    if (confirm('Do you agree to the use of cookies?')) {
        // If the user agrees, set a cookie to remember the consent
        let expiryDate = new Date();
        expiryDate.setFullYear(expiryDate.getDate() + 1); // Expire cookie in 1 day
        document.cookie = 'cookieAgreed=true; expires=' + expiryDate.toUTCString() + '; path=/';
    }
}
