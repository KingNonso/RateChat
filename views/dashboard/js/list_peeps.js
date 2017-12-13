function SendFriendShipRequest(viewer,owner,cls){
    _("send_"+owner).style.display = 'none';
    _("friend_"+owner).innerHTML = 'Please wait...';

    var ajax = ajaxObj("POST", "../../dashboard/SendFriendShipRequest");

    ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
            if((ajax.responseText) == 'error'){
                _("friend_"+owner).innerHTML = 'Oops...';

            } else {
                var reply = (cls == 'friend_request')? 'Request Sent' : (cls == 'fan' ) ? 'Fanning' : 'Following';

                _("friend_"+owner).innerHTML = reply;
            }
        }
    }
    ajax.send("sender="+viewer+"&receiver="+owner+"&class="+cls);


}

function AcceptFriendRequest(viewer,owner,cls){
    _("send_"+owner).style.display = 'none';
    _("friend_"+owner).innerHTML = 'Please wait...';

    var ajax = ajaxObj("POST", "../../dashboard/AcceptFriendRequest");

    ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
            if((ajax.responseText) == 'error'){
                _("friend_"+owner).innerHTML = 'Oops...';

            } else {
                var reply = (cls == 1)? 'You are now friends' : (cls == 2 ) ? 'New Fan Added' : 'New follower added';

                _("friend_"+owner).innerHTML = reply;
            }
        }
    }
    ajax.send("sender="+viewer+"&receiver="+owner+"&class="+cls);


}

function RemoveFriendRequest(viewer,owner,cls){
    _("send_"+owner).style.display = 'none';
    _("friend_"+owner).innerHTML = 'Please wait...';

    var ajax = ajaxObj("POST", "../../dashboard/RemoveFriendRequest/"+cls);

    ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
            if((ajax.responseText) == 'error'){
                _("friend_"+owner).innerHTML = 'Oops...';

            } else {
                var reply = (cls == 'Decline')? 'Declined' :  'Cancelled';

                _("friend_"+owner).innerHTML = reply;
            }
        }
    }
    ajax.send("sender="+viewer+"&receiver="+owner+"&class="+cls);


}

function BlockFriend(viewer,owner,cls){
    _("send_"+owner).style.display = 'none';
    _("friend_"+owner).innerHTML = 'Please wait...';

    var ajax = ajaxObj("POST", "../../dashboard/AcceptFriendRequest/1");

    ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
            if((ajax.responseText) == 'error'){
                _("friend_"+owner).innerHTML = 'Oops...';

            } else {
                var reply = (cls == 1)? 'Blocked' : (cls == 2 ) ? 'Fan Removed' : 'Follower Removed';

                _("friend_"+owner).innerHTML = reply;
            }
        }
    }
    ajax.send("sender="+viewer+"&receiver="+owner+"&class="+cls);


}






