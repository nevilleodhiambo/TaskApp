import { ref } from "vue";
import { makeHttpReq } from "../../../helper/makeHttpReq";


export type RegisterUserType = {
    email: string;
    password:string
}
export type RegisterResponseType = {
    email: string;
    password:string
}
export const registerInput = ref<RegisterResponseType>({} as RegisterResponseType)
export function useRegisterUser(){
   
    try {
        const loading = ref(false)
        async function register() {
            loading.value = true
            const data = await makeHttpReq<RegisterUserType,RegisterResponseType>
        ('register', 'POST', registerInput.value)
        loading.value = false
        console.log(data.message)
        }
    } catch (error) {
        console.log(error.message)
        
    }
    return {register}
}