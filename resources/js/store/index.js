import axios from "axios"

export default {
    state: {
        //
        userList:[]
    },
    mutations: { 
        //
        userList(state,payload)
        {
          return  state.userList = payload
        }
    },
    actions: {  
        userList(context) {
            axios.get("/api/userlsit")
            .then((response) => {
                context.commit("userList",response.data)
            })
        }
    },
    getters: { 
        //
        userList(state){
           return state.userList
        }
    }
}