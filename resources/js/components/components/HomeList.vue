<template>
	<nav-bar :products="products" :user="user" title="Home page" />
	<main-banner />
	<section class="container">
		<div v-for="{ id, name } in categories_data" :key="id">
			<div class="d-flex justify-content-between align-items-baseline mx-3 mt-3">
				<p
					class="fs-4">{{ name }}</p>
					<a :href="'/category/get-products/'+id"
					class="fs-4 pe-auto link-underline link-underline-opacity-0">Ver mas <i class="fa-solid fa-arrow-right"></i></a>
			</div>
			<div class="w-100 d-md-flex flex-wrap">
				<product-list :category="id" />
			</div>

		</div>
	</section>
	<v-footer />
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


		/**
		 * Filter the categories with content to avoid render empty categories
		 */
		const filterCategoriesEmpties = () => {
			categories_data.value = props.categories.filter(category => category.products.length > 0)
		}

		onMounted(() => {
			saveUserInfo(props.user)
			filterCategoriesEmpties()
		})

		return {
			categories_data,
		}
	}
}
</script>
