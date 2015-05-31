function validate(form)
{
    fail = validateFirstName(form.firstname.value);
    fail+= validateLastName(form.lastname.value);
    fail+= validateUserName(form.user.value);
    fail+= validatePassword(form.pass.value);
    fail+= validateEmail(form.email.value);
}

function validateFirstName(field)
{
    return (field=="") ? "No First Name was entered.\n" : "";
}

function validateLastName(field)
{
    return (field=="") ? "No Last Name was entered.\n" : "";
}

function validateUserName(field)
{
    if(field=="") return "No Username was entered.\n";
    else if (field.length < 5)
        return "Username must be at least 5 characters and contain only alphanumeric characters";
    else if (/[^a-zA-Z0-9_-]/.test(field))
        return "Only a-z, A-Z, 0-9, - and _ allowed in usernames.\n";
    return "";
}

function validatePassword(field)
{
    if(field=="") return "No Password was entered.\n";
    else if (field.length < 6)
        return "Passwords must be at least 6 characters";
    else if (!/[a-z]/.test(field) || !/[A-Z]/.test(field) || !/[0-9]/.test(field))
        return "Passwords require at least one each of uppercase, lowercase and numbers.\n";
    return "";
}

function validateAge(field)
{
    if(isNaN(field)) return "No Age was entered.\n";
    else if (field < 18 || field > 110)
        return "Age must be between 18 and 110.\n";
    return "";
}

function validateEmail(field)
{
    if(field=="") return "No Email was entered.\n";
    else if (!((field.indexOf(".") > 0) &&
        (field.indexOf("@") > 0)) || /[^a-zA-Z0-9.@_-]/.test(field))
        return "The email address is invalid.\n";
    return "";
}