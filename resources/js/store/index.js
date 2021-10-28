import axios from "axios"

export default {
    state: {
        //
    },
    mutations: { 
        //
    },
    actions: {  
        SET_USER(state) {
            axios.get("loadCategories")
        }
    },
    getters: { 
        //
    }
}