/*
toggleGuestList(string)
purpose:  to enable or disable the guest list definition form.
*/
function toggleGuestList(type) {
    switch(type) {
    case "1":
        document.getElementById("bnid_add").disabled=true;
        document.getElementById("bnids_added").disabled=true;
        document.getElementById("bnid_remove").disabled=true;
        document.getElementById("bnids_removed").disabled=true;
        document.getElementById("user_add").disabled=true;
        document.getElementById("users_added").disabled=true;
        document.getElementById("user_remove").disabled=true;
        document.getElementById("users_removed").disabled=true;
        break;
    case "2":
        document.getElementById("bnid_add").disabled=false;
        document.getElementById("bnids_added").disabled=false;
        document.getElementById("bnid_remove").disabled=false;
        document.getElementById("bnids_removed").disabled=false;
        document.getElementById("user_add").disabled=false;
        document.getElementById("users_added").disabled=false;
        document.getElementById("user_remove").disabled=false;
        document.getElementById("users_removed").disabled=false;
        break;
    default:
        document.getElementById("bnid_add").disabled=true;
        document.getElementById("bnids_added").disabled=true;
        document.getElementById("bnid_remove").disabled=true;
        document.getElementById("bnids_removed").disabled=true;
        document.getElementById("user_add").disabled=true;
        document.getElementById("users_added").disabled=true;
        document.getElementById("user_remove").disabled=true;
        document.getElementById("users_removed").disabled=true;
    }
}

/*
moveGuest(string)
purpose:  to move selected options from one sub-guest list to 
another.
*/
function moveGuest(direction) {
    switch(direction) {
    case "bnid_add":
        var inny=document.getElementById("bnids_added");
        var outy=document.getElementById("bnids_removed");
        for(var i=0;i<outy.length;i++) {
            if(outy.options[i].selected==true) {
                var guest=document.createElement("option");
                guest.text=outy.options[i].text;
                guest.value=outy.options[i].value;
                outy.remove(i);
                inny.add(guest,null);
                guest=null;
            }
        }
        break;
    case "bnid_remove":
        var inny=document.getElementById("bnids_removed");
        var outy=document.getElementById("bnids_added");
        for(var i=0;i<outy.length;i++) {
            if(outy.options[i].selected==true) {
                var guest=document.createElement("option");
                guest.text=outy.options[i].text;
                guest.value=outy.options[i].value;
                outy.remove(i);
                inny.add(guest,null);
                guest=null;
            }
        }
        break;
    case "user_add":
        var inny=document.getElementById("users_added");
        var outy=document.getElementById("users_removed");
        for(var i=0;i<outy.length;i++) {
            if(outy.options[i].selected==true) {
                var guest=document.createElement("option");
                guest.text=outy.options[i].text;
                guest.value=outy.options[i].value;
                outy.remove(i);
                inny.add(guest,null);
                guest=null;
            }
        }
        break;
    case "user_remove":
        var inny=document.getElementById("users_removed");
        var outy=document.getElementById("users_added");
        for(var i=0;i<outy.length;i++) {
            if(outy.options[i].selected==true) {
                var guest=document.createElement("option");
                guest.text=outy.options[i].text;
                guest.value=outy.options[i].value;
                outy.remove(i);
                inny.add(guest,null);
                guest=null;
            }
        }
        break;
    default:
        alert("Error: invalid field name specified.");
    }
}
