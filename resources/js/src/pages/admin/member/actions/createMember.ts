import { ref } from "vue";
import { makeHttpReq } from "../../../../helper/makeHttpReq";
import { successMsg } from "../../../../helper/toast-notification";
import { showErrorResponse } from "../../../../helper/util";


export type MemberInputType = {
    name:string;
  email: string;
  password: string;
};

export type MemberResponseType = {
  user: { email: string };
  message: string;
};

export const MemberInput = ref<MemberInputType>({} as MemberInputType);

export function useCreateOrUpdateMember() {
  const loading = ref(false);

  async function createorUpdate() {
    try {
      loading.value = true;
      const data = await makeHttpReq<MemberInputType, MemberResponseType>(
        'members',
        'POST',
        MemberInput.value
      );
      loading.value = false;
      MemberInput.value = {} as MemberInputType
      successMsg(data.message);
    } catch (error) {
      loading.value = false;
      // Assuming error is an array of strings
      showErrorResponse(error)
    }
  }

  return { createorUpdate, loading };
}
