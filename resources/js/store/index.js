import axios from "axios"

export default {
    state: {
        //
    },
    mutations: { 
        //
    },
    actions: {  
        userList(state) {
            axios.get("/userlsit")
            .then((response) => {
                console.log(response);
            })
        }
    },
    getters: { 
        //
    }
}