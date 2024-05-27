function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(";");
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == " ") {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

$(document).ready(function () {
    console.log(getCookie("username"));
    $("#registerForm").on("submit", function (e) {
        e.preventDefault();
        const formdata = new FormData($("#registerForm")[0]);
        $.ajax({
            url: base_url + "api/v1/auth/register-user",
            data: formdata,
            type: "POST",
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status) {
                    toastr.success(response.message);
                    setTimeout(function () {
                        window.location.href = base_url;
                    }, 3000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
    $("#loginForm").on("submit", function (e) {
        e.preventDefault();
        const formdata = new FormData($("#loginForm")[0]);
        $.ajax({
            url: base_url + "api/v1/auth/validate-credentials",
            data: formdata,
            type: "POST",
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status) {
                    toastr.success(response.message);
                    setCookie('username',response.data.username,1);
                    setCookie('email',response.data.email,1);
                    setCookie('authToken',response.authToken,1);
                    setTimeout(function () {
                        window.location.href = base_url;
                    }, 3000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
});
