<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Trading Options
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <user-symbol-preference v-for="preference in userSymbols"
                    :userSymbolPreference="preference"
                ></user-symbol-preference>
                <user-symbol-preference v-for="empty in systemEnabledSymbols"
                    :emptyPreference="empty"
                ></user-symbol-preference>
            </div>
        </div>
    </breeze-authenticated-layout>
</template>

<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'
    import UserSymbolPreference from "../../Components/UserSymbolPreference";

    export default {
        components: {
            UserSymbolPreference,
            BreezeAuthenticatedLayout,
        },
        props: {
            systemEnabledSymbols: {
                type: Object
            },
            userSymbols: {
                type: Object
            }
        },
    }
</script>
