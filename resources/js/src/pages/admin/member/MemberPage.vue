<script lang="ts">
import MemberTable from "./components/MemberTable.vue";

</script>
<template>
    <h1>Member Page</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Member List
                        <RouterLink style="float: right;" to="/create-members" class="btn btn-primary">Create Members</RouterLink>
                    </div>
                    <div class="card-body">
                        <member-table></member-table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
