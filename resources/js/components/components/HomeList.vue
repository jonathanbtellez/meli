<template>
	<nav-bar :products="products" :user="user" title="Home page" />
	<main-banner />
	<section class="container">
		<div v-for="{ id, name } in categories_data" :key="id">
			<button @click="go_to_category(id)" class="fs-4 btn btn-outline-secondary btn-sm ms-3 ms-md-3 ms-lg-2 my-2 my-lg-0 mb-lg-2">{{ name }}</button>
			<div class="w-100 d-md-flex flex-wrap">
				<product-list :category="id" />
			</div>

		</div>
	</section>
	<v-footer/>
</template>
<script>
import { onMounted, ref } from 'vue';
import ProductList from '../product/ProductList.vue';
import useLocalStorage from '../../composables/useLocalStorage';
export default {
	components: {
		ProductList
	},
	props: ['user', 'products', 'categories'],
	setup(props) {
		const { updateStorage } = useLocalStorage()
		const categories_data = ref();
		/**
		 * Save the user info in the storage to be use for save purchases
		 */
		const saveUserInfo = (user) => {
			if (!user) return
			updateStorage('user', { id: user.id })
		}

		onMounted(() => {
			saveUserInfo(props.user)
			filterCategoriesEmpties()
		})

		/**
		 * Filter the categories with content to avoid render empty categories
		 */
		const filterCategoriesEmpties = () => {
			categories_data.value = props.categories.filter(category => category.products.length > 0)
			console.log('====================================');
			console.log(categories_data.value);
			console.log('====================================');
		}

		return {
			go_to_category: (id) => window.location.href = `/category/get-products/${id}`,
			categories_data
		}
	}
}
</script>

