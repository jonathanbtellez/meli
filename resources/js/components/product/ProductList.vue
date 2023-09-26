<template >
	<div class="w-100" v-if="is_loading">
		<div class="loader"></div>
	</div>
	<template v-else>
		<div v-for="product in products_by_category" :key="product.id" class="card-size mb-3">
			<product-card :product="product" />
		</div>
	</template>
</template>
<script>

import ProductCard from './ProductCard.vue';
import { onMounted, ref } from 'vue';

export default {
	components: {
		ProductCard
	},
	props: ['category'],
	setup(props) {
		const products_by_category = ref({})
		const is_loading = ref(true)

		/**
		 * Get the list of product related to the category id
		 * @param {number} id
		 */
		const getProductsByCategory = async (id) => {
			try {
				const { data } = await axios(`/product/getByCategory/${id}`)
				products_by_category.value = data.products.slice(0, 5)
				is_loading.value = false
			} catch (error) {
				console.error(error);
			}
		}
		onMounted(async () => {
			await getProductsByCategory(props.category)
		})

		return {
			is_loading,
			products_by_category,
		}
	}
}
</script>

