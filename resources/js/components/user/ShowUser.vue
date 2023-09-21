<template>
	<nav-bar :products="products" :user="user" title="Home page" />

	<v-footer/>
</template>
<script>
import { onMounted } from 'vue';
import ProductList from '../product/ProductList.vue';
import useLocalStorage from '../../composables/useLocalStorage';
export default {
	components: {
		ProductList
	},
	props: ['user', 'products', 'categories'],
	setup(props) {
		const { updateStorage } = useLocalStorage()

		/**
		 * Save the user info in the storage to be use for save purchases
		 */
		const saveUserInfo = (user) => {
			if (!user) return
			updateStorage('user', { id: user.id })
		}

		onMounted(() => {
			saveUserInfo(props.user)
		})

		return {
			go_to_category: (id) => window.location.href = `/category/get-products/${id}`
		}
	}
}
</script>

