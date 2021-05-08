<template>
    <div class="flex items-center gap-8">
        <label class="inline-flex items-center" v-for="(option, index) in options">
            <input type="radio" :name=name class="h-5 w-5 text-indigo-700" :disabled="disabled" :value="option" :checked="index === options.indexOf(selected)"
                   v-on:select="this.selected = option"
            />
            <span class="ml-2 text-gray-700">
                {{ option }}
            </span>
        </label>
    </div>
</template>

<script>
export default {
    name: "Radio",
    props: {
        disabled: {
            type: Boolean,
            default: false,
        },
        name: {
            type: String
        },
        options: {
            type: Array
        },
        selected: {
            type: String
        },
        watch: {
            selected: function(val)
            {
                this.$dispatch('selected', val)
            }
        }
    }
}
</script>

<style scoped>

</style>
