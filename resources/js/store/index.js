import axios from "axios"

export default {
    state: {
        //
        userList:[],
        userMessage:[]
    },
    mutations: { 
        //
        userList(state,payload)
        {
          return  state.userList = payload
        },
        userMessage(state,payload)
        {
            return state.userMessage = payload
        }
    },
    actions: {  
        userList(context) {
            axios.get("/userlsit")
            .then((response) => {
                context.commit("userList",response.data.data)
            })
        },
        userMessage(context,payload) {
            axios.get("/usermessage/"+payload)
            .then((response) => {
                context.commit("userMessage",response.data)
            })
        }
    },
    getters: { 
        //
        userList(state){
           return state.userList
        },
        userMessage(state) {
            return state.userMessage
        }
    }
}