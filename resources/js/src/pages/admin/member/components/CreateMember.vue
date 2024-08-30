<script lang="ts" setup>
import { useVuelidate } from "@vuelidate/core";
import { required, email } from "@vuelidate/validators";

import Error from "../../../../components/Error.vue";
import BaseBtn from "../../../../components/BaseBtn.vue"
import BaseInput from "../../../../components/BaseInput.vue"

import { MemberInput, useCreateOrUpdateMember } from "../actions/createMember";


const rules = {
    email: { required, email }, // Matches state.firstName
    password: { required }, // Matches state.lastName
};

const v$ = useVuelidate(rules, MemberInput);
const { loading, createorUpdate } = useCreateOrUpdateMember();
async function submitMember() {
    console.log("Form submitted");
    const result = await v$.value.$validate();

    console.log("Validation result:", result); // This should be false
    console.log("Validation errors:", v$.value.$errors); // Log validation errors

    if (!result) return;

    await createOrUpdate();
    v$.value.$reset();
}


</script>
<template>
    
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1>Create Members</h1>
                <br>
                <br>
                <form @submit.prevent="submitMember">
                    <div class="form-group">
                        <!-- <Error label="Name" :errors="v$.name.$errors"> -->
                            <BaseInput v-model="MemberInput.name" />
                        <!-- </Error> -->
                    </div>
                    <div class="form-group">
                        <Error label="E-mail" :errors="v$.email.$errors">
                            <BaseInput v-model="MemberInput.email" />
                        </Error>
                    </div>
                    <br>
                    <RouterLink to="/members">See members list</RouterLink>
                    <br>
                    <div class="form-group">

                        <BaseBtn label="Create Member" :loading="loading" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>