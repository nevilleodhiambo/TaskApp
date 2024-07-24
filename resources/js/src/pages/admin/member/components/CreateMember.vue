<script lang="ts" setup>
import { useVuelidate } from "@vuelidate/core";
import { required, email } from "@vuelidate/validators";
import { MemberInput, useCreateOrUpdateMember } from "./actions/createMember";
// import BaseBtn from "../../components/BaseBtn.vue"
// import BaseInput from "../../components/BaseInput.vue"

const rules = {
    email: { required, email }, // Matches state.firstName
    password: { required }, // Matches state.lastName
};

const v$ = useVuelidate(rules, MemberInput);
const { loading, createorUpdate } = useCreateOrUpdateMember();
// async function submitLogin() {
//     const result = await v$.value.$validate();

//     if (!result) return;

//     await login();
//     v$.value.$reset()

// }
</script>
<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="createorUpdate">
                    <label for="name">Name</label>
                    <div class="form-group">
                        <Error label="Name" :errors="v$.name.$errors">
                            <BaseInput v-model="MemberInput.name" />
                        </Error>
                    </div>
                    <label for="name">E-mail</label>
                    <div class="form-group">
                        <Error label="Name" :errors="v$.email.$errors">
                            <BaseInput v-model="MemberInput.email" />
                        </Error>
                    </div>
                    <div class="form-group">

                        <BaseBtn label="create Member" :loading="loading" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>