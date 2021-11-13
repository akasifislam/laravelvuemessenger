<template>
    <div class="container-chat clearfix">
        <div class="people-list" id="people-list">
            <div class="search">
                <input type="text" placeholder="search" />
                <i class="fa fa-search"></i>
            </div>
            <ul class="list">
                <!-- {{ userList }} -->
                <li
                    @click.prevent="selectUser(user.id)"
                    class="clearfix"
                    v-for="user in userList"
                    :key="user.id"
                >
                    <img
                        width="50" height="60"
                        src="https://www.pngall.com/wp-content/uploads/5/User-Profile-PNG.png"
                    />
                    <div class="about">
                        <div class="name">{{ user.name }}</div>
                        <div class="status">
                            <div v-if="onlineUser(user.id)"><i class="fa fa-circle online"></i> online</div>
                            
                           <div v-else> <i class="fa fa-circle offline"></i> offline</div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="chat">
            <div class="chat-header clearfix">
                <img
                    src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_01_green.jpg"
                    alt="avatar"
                />

                <div class="chat-about">
                    <div class="chat-with" v-if="userMessage.user">
                        {{ userMessage.user.name }}
                    </div>
                    <div class="chat-num-messages p-2">
                        already 1 902 messages
                    </div>
                    &nbsp;&nbsp;
                </div>
                <ul class="dropdown show">
                    <a
                        class=""
                        href="#"
                        role="button"
                        id="dropdownMenuLink"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                        </svg>
                    </a>

                    <div
                        class="dropdown-menu"
                        aria-labelledby="dropdownMenuLink"
                    >
                        <a
                            @click.prevent="deleteAllMessage"
                            class="dropdown-item"
                            href="#"
                            >Delete All Message</a
                        >
                    </div>
                </ul>
                <i class="fa fa-star"></i>
            </div>
            <!-- end chat-header -->

            <div class="chat-history" v-chat-scroll>
                <ul>
                    <li
                        class="clearfix"
                        v-for="message in userMessage.message"
                        :key="message.id"
                    >
                        <div class="message-data align-right">
                            <span class="message-data-time">
                                {{ message.created_at | timeformat }}
                            </span>
                            <span class="message-data-name">
                                {{ message.user.name }}
                            </span>
                            <i class="fa fa-circle me"></i>
                            <ul class="dropdown show">
                                <a
                                    class=""
                                    href="#"
                                    role="button"
                                    id="dropdownMenuLink"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                    <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                    </svg>
                                </a>

                                <div
                                    class="dropdown-menu"
                                    aria-labelledby="dropdownMenuLink"
                                >
                                    <a
                                        @click.prevent="
                                            deleteSingleMessage(message.id)
                                        "
                                        class="dropdown-item"
                                        href="#"
                                        >Delete</a
                                    >
                                </div>
                            </ul>
                        </div>
                        <div
                            class="message float-right"
                            :class="
                                `${
                                    message.user.id == userMessage.user.id
                                        ? 'other-message'
                                        : 'my-message'
                                }`
                            "
                        >
                            {{ message.message }}
                        </div>
                    </li>
                </ul>
            </div>
            <!-- end chat-history -->

            <div class="chat-message clearfix">
                <p style="color:blue" v-if="typeing">{{ typeing }} is typeing</p>
                <textarea
                    v-if="userMessage.user"
                    @keydown.enter="sendMessage"
                    @keydown="typeingEvent(userMessage.user.id)"
                    v-model="message"
                    name="message-to-send"
                    id="message-to-send"
                    placeholder="Type your message"
                    rows="3"
                ></textarea>
                <textarea
                    v-else
                    disabled
                    @keydown.enter="sendMessage"
                    v-model="message"
                    name="message-to-send"
                    id="message-to-send"
                    rows="3"
                ></textarea>

                <i class="fa fa-file-o"></i> &nbsp;&nbsp;&nbsp;
                <i class="fa fa-file-image-o"></i>

                <!-- <button>Send</button> -->
            </div>
            <!-- end chat-message -->
        </div>
        <!-- end chat -->
    </div>
</template>

<script>
import _ from 'lodash'

export default {
    mounted() {
        Echo.private(`chat.${authuser.id}`).listen(
            "MessageSend",
            (e) => {
                this.selectUser(e.message.form);
                // console.log(e.message.message);
            }
        );
        this.$store.dispatch("userList");

        Echo.private('typeingevent')
        .listenForWhisper('typing', (e) => {
            // console.log(authuser.id);
            // console.log(e.userId);
            // console.log(e.user.id);
            // console.log(this.userMessage.user.id);
            if (authuser.id == e.userId &&  e.user.id ==this.userMessage.user.id) {
                
                this.typeing = e.user.name
            }
           setTimeout(() => {
               this.typeing = ''
           },2000);
        });
    },
    data() {
        return {
            message: "",
            typeing: "",
            users: []
        };
    },
    computed: {
        userList() {
            return this.$store.getters.userList;
        },
        userMessage() {
            return this.$store.getters.userMessage;
        }
    },

    created() {
        Echo.join('liveuser')
        .here((users) => {
            this.users = users
        })
        .joining((user) => {
            this.users = user
        })
        .leaving((user) => {
            console.log(user.name);
        })
        .error((error) => {
            console.error(error);
        });
    },
    methods: {
        selectUser(userId) {
            this.$store.dispatch("userMessage", userId);
        },
        sendMessage(e) {
            e.preventDefault();
            if (this.message != "") {
                axios
                    .post("/sendmessage", {
                        message: this.message,
                        user_id: this.userMessage.user.id
                    })
                    .then(response => {
                        this.selectUser(this.userMessage.user.id);
                    });
                this.message = "";
            }
        },
        deleteSingleMessage(messageId) {
            axios.get(`/deletesinglemessage/${messageId}`).then(response => {
                this.selectUser(this.userMessage.user.id);
            });
        },
        deleteAllMessage() {
            axios
                .get(`/deleteallmessage/${this.userMessage.user.id}`)
                .then(response => {
                    this.selectUser(this.userMessage.user.id);
                });
        },
        typeingEvent(userId) {
            Echo.private('typeingevent')
            .whisper('typing', {
                'user': authuser,
                'typeing': this.message,
                'userId' : userId
            
            });
        },
        onlineUser(userId) {
            return _.find(this.users,{'id': userId});
        }
    }
};
</script>

<style>
.people-list ul {
    overflow-y: scroll !important;
}
/* width */
::-webkit-scrollbar {
    width: 4px;
}

/* Track */
::-webkit-scrollbar-track {
    box-shadow: inset 0 0 5px rgb(2, 151, 59);
    border-radius: 10px;
}

/* Handle */
::-webkit-scrollbar-thumb {
    background: rgb(255, 255, 255);
    border-radius: 10px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
    background: #b30000;
}
</style>
