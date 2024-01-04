import { clientAuthFetch } from "@/utils/clientFetch";
import { defineStore } from "pinia";

export const useAuth = defineStore("auth", {
    state() {
        return{
            isAuth: false,
            token: ""
        }
    },
    actions: {
        setToken(token: string){
            this.token = token
            localStorage.setItem("token", token)
        },

        authStatus(status: boolean){
            this.isAuth = status
        },
        
        async verifyAuth(){
            const token = localStorage.getItem("token")
            if (token != null) {
                try {
                    await clientAuthFetch.get("/auth", {
                        headers: {
                            Authorization: `Bearer ${token}`
                        }
                    })
                    this.token = token
                    this.isAuth = true
                } catch (e) {
                    console.log(e)
                }
            }
        },

        logout(){
            localStorage.removeItem("token")
            this.isAuth = false
            this.token = ""
        }
    }
})