import { ref } from "vue";
import { makeHttpReq } from "../../../helper/makeHttpReq";
import { showError, successMsg } from "../../../helper/toast-notification";

export type LoginUserType = {
  email: string;
  password: string;
};

export type LoginResponseType = {
  user: { email: string };
  message: string;
};

export const loginInput = ref<LoginUserType>({} as LoginUserType);
   
export function showErrorResponse(error:unknown){
    if(Array.isArray(error)){
        for(const message of error as string[]){
        showError(error)
        }
    }else{
        showError(error as Error).message
    }
}

export function useLoginUser() {
  const loading = ref(false);

  async function login() {
    try {
      loading.value = true;
      const data = await makeHttpReq<LoginUserType, LoginUserType>(
        'login',
        'POST',
        loginInput.value
      );
      loading.value = false;
      loginInput.value = { email: "", password: "" };
      successMsg(data.message);
    } catch (error) {
      loading.value = false;
      // Assuming error is an array of strings
      if (Array.isArray(error)) {
        for (const message of error) {
          showError(message);
        }
      } else {
        // Handle other types of errors or unknown structure
        showError("An error occurred during registration.");
        console.error("Error during registration:", error);
      }
    }
  }

  return { login, loading };
}
