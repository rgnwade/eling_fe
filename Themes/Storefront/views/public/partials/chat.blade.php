@auth
<script type="text/javascript">
    (function(d, m){var s, h;
    s = document.createElement("script");
    s.type = "text/javascript";
    s.async=true;
    s.src="https://apps.applozic.com/sidebox.app";
    h=document.getElementsByTagName('head')[0];
    h.appendChild(s);
    window.applozic=m;
    m.init=function(t){m._globals=t;}})(document, window.applozic || {});
</script>

<script type="text/javascript">
    var chatAdmins = {!! json_encode(chat_admins()) !!}

window.applozic.init({
    appId: '{{ config('app.applozic') }}',
    userId: "{{Auth::user()->uuid}}",
    accessToken: "{{Auth::user()->api_token}}",
    userName: "{{Auth::user()->first_name. ' ' . Auth::user()->last_name}}",
    imageLink : '',
    email : "{{Auth::user()->email}}",
    contactNumber: '',
    desktopNotification: true,
    source: '1',
    notificationIconLink: 'https://www.applozic.com/favicon.ico',
    authenticationTypeId: 0,
    locShare: false,
    unreadCountOnchatLauncher: true,
    googleMapScriptLoaded : false,
    autoTypeSearchEnabled : false,
    loadOwnContacts : true,
    olStatus: true,
    topicBox: true,
    getTopicDetail: function (topicId) {},
    onInit : function(response,data) {
        if (response === "success") {
            $applozic.fn.applozic('loadContacts', {"contacts":chatAdmins});
            startButton = document.getElementById("mck-msg-new");
            startButton.innerHTML = "Admin Support";
        } else {
            console.log(response)
        }
    }
});

function setupUser(adminList, user, company) {
    var users = chatAdmins.map (function (admin){
        return {
            'userId': admin.userId,
            'displayName': "Admin-" + admin.displayName,
            'groupRole': 1
        }
    });
    users.push({ 'userId': user.id, 'displayName': user.name, 'groupRole': 0})
    users.push({ 'userId': company.id, 'displayName': 'Seller-'+company.name,'groupRole': 0})
    return users;
}

function editAdmin(clientGroupId, userId){
    $applozic.fn.applozic('updateGroupInfo',
        {
            'clientGroupId' : clientGroupId,
            'users': [{userId: userId, role:0}],
            'callback' : function(response){console.log(response);}
        }
    );
}

function loadTab(clientGroupId){
    $applozic.fn.applozic(
        'loadGroupTabByClientGroupId',
        {'clientGroupId': clientGroupId}
    );

}

function loadContextTab(groupId, context){
    $applozic.fn.applozic(
        'loadContextualTab',({
        'groupId': groupId,
        'topicId': context.productId,
        "topicDetail" :
            {
                title : context.productName,
                subtitle : context.price,
                link : context.imageLink,
            },
        'isGroup':true,
        'status': "new"
        })
    );
}

function stopLoading(){
    chatButton = document.getElementById("chat-button");
    chatButton.classList.remove('btn-loading')
    chatButton.classList.remove('disabled')
    chatButton.removeAttribute('disabled')
}

function sendMessage(clientGroupId, messageText) {
    $applozic.fn.applozic('sendGroupMessage',
        {
            'clientGroupId' : clientGroupId,
            'message' : messageText
   });
}

var loadGroupChat = function(clientGroupId, groupName, company, user, icon) {
    Applozic.ALApiService.getGroupInfo({
        data: {
            clientGroupId: clientGroupId,
        },
        success: function (response) {
            if(response.status === 'error') {
                var users = setupUser(chatAdmins, user, company)
                $applozic.fn.applozic('createGroup', {
                    'groupName': groupName,
                    'clientGroupId': clientGroupId,
                    'groupIcon' : icon,
                    'adminId': chatAdmins[0].userId,
                    'type': 1,
                    'users': users,
                    'callback': function (response) {
                        editAdmin(clientGroupId, user.id)
                        loadTab(clientGroupId)
                        stopLoading()
                    }
                });
            } else {
                loadTab(clientGroupId)
                stopLoading()
            }
        },
        error: function (response) {}
    });
};

var loadGroupChatWithContext = function(clientGroupId, groupName, company, user, icon, context) {
    Applozic.ALApiService.getGroupInfo({
        data: {
            clientGroupId: clientGroupId,
        },
        success: function (response) {
            message = context.productName + ' ' + context.productLink
            if(response.status === 'error') {
                var users = setupUser(chatAdmins, user, company)
                $applozic.fn.applozic('createGroup', {
                    'groupName': groupName,
                    'clientGroupId': clientGroupId,
                    'groupIcon' : icon,
                    'type': 1,
                    'users': users ,
                    'callback': function (response) {
                        editAdmin(clientGroupId, user.id)
                        loadContextTab(parseInt(response.data.value), context)
                        sendMessage(clientGroupId, message)
                        stopLoading()
                    }
                });
            } else {
                loadContextTab(response.response.id, context)
                sendMessage(clientGroupId, message)
                stopLoading()
            }
        },
        error: function (response) {}
    });
};

</script>
@endauth
