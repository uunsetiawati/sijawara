<template>
</template>

<script>
	export default {
		data() {
			return {
				
			}
		},
		methods: {
            check() {

            }
		},
		mounted() {
			this.$router.push({name: this.$auth.user().level});
		}
	}
</script>