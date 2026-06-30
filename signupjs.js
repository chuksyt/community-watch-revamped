function redirect() {
    var fn = document.getElementById("fulln").value;
    if (!/^[a-zA-Z]+ [a-zA-Z]+$/.test(fn)) {
        alert("Invalid Full Name — must be first and last name");
        return false;
    }

    var un = document.getElementById("usern").value;
    if (!/^[a-zA-Z0-9]+$/.test(un)) {
        alert("Invalid Username — letters and numbers only");
        return false;
    }

    var pw = document.getElementById("passw").value;
    if (pw.length < 8) {
        alert("Password must be at least 8 characters");
        return false;
    }

    var ad = document.getElementById("aadhaar").value;
    if (ad.trim().length === 0) {
        alert("NIN is required");
        return false;
    }

    var mn = document.getElementById("mobno").value;
    if (mn.trim().length === 0) {
        alert("Mobile number is required");
        return false;
    }

    return true;
}
