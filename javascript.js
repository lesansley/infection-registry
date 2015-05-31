canvas = O('logo');
context = canvas.getContext('2d');
context.font = 'bold italic 97 Georgia';
context.textBaseline = 'top';
image = new Image();
image.src = 'logo.png';

image.onload = function()
{
    gradient = context.createLinearGradient(0,0,0,89);
    gradient.addColorStop(0.00, '#ffa');
    gradient.addColorStop(0.66, '#f00');
    context.fillStyle = gradient;
    context.fillText(" utcomes Project", 0, 0);
    context.strokeText(" utcomes Project", 0, 0);
    context.drawImage(image, 64, 32);
}

function O(obj)
{
    if (typeof obj == 'object') return obj;
    else return document.getElementById(obj);
}

function S(obj)
{
    return O(obj).style;
}

function C(name)
{
    var elements = document.getElementsByTagName('*');
    var objects = [];
    
    for (var i=0; i<elements.length; ++i)
        if (elements[i].className == name)
        objects.push(elements[i]);
        
    return objects;
}

function validateForename(field)
      {
        return (field == "") ? "No Forename was entered.\n" : ""
      }

      function validateSurname(field)
      {
        return (field == "") ? "No Surname was entered.\n" : ""
      }

      function validateUsername(field)
      {
        if (field == "") return "No Username was entered.\n"
        else if (field.length < 5)
          return "Usernames must be at least 5 characters.\n"
        else if (/[^a-zA-Z0-9_-]/.test(field))
          return "Only a-z, A-Z, 0-9, - and _ allowed in Usernames.\n"
        return ""
      }

      function validatePassword(field)
      {
        if (field == "") return "No Password was entered.\n"
        else if (field.length < 6)
          return "Passwords must be at least 6 characters.\n"
        else if (!/[a-z]/.test(field) || ! /[A-Z]/.test(field) ||
                 !/[0-9]/.test(field))
          return "Passwords require one each of a-z, A-Z and 0-9.\n"
        return ""
      }

      function validateAge(field)
      {
        if (isNaN(field)) return "No Age was entered.\n"
        else if (field < 18 || field > 110)
          return "Age must be between 18 and 110.\n"
        return ""
      }

      function validateEmail(field)
      {
        if (field == "") return "No Email was entered.\n"
          else if (!((field.indexOf(".") > 0) &&
                     (field.indexOf("@") > 0)) ||
                    /[^a-zA-Z0-9.@_-]/.test(field))
            return "The Email address is invalid.\n"
        return ""
      }