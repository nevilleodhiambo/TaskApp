import { ref } from "vue";
import { makeHttpReq } from "../../../helper/makeHttpReq";
import { showError, successMsg } from "../../../helper/toast-notification";

export type RegisterUserType = {
  email: string;
  password: string;
};

export type RegisterResponseType = {
  user: { email: string };
  message: string;
};

export const registerInput = ref<RegisterUserType>({ email: "", password: "" });

export function useRegisterUser() {
  const loading = ref(false);

  async function register() {
    try {
      loading.value = true;
      const data = await makeHttpReq<RegisterUserType, RegisterResponseType>(
        'register',
        'POST',
        registerInput.value
      );
      loading.value = false;
      registerInput.value = { email: "", password: "" };
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

  return { register, loading };
}
