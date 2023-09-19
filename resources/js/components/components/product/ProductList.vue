<template >
	<div v-for="product in category_data" :key="product.id" class="card-size">
		<div class="card m-2">
			<img :src="product.image.url" class="card-img-top" alt="Product image">
			<div class="card-body">
				<h5 class="card-title">{{ product.name }}</h5>
				<p class="card-text">{{ product.format_description }}</p>
				<p class="card-text">{{ price(product.price) }}</p>
				<div class="d-flex justify-content-around">
					<a href="#" class="btn btn-secondary"><i class="fa-regular fa-eye"></i></a>
					<button class="btn btn-primary"><i class="fa-solid fa-cart-shopping"></i></button>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
import { onMounted, ref } from 'vue';
import { moneyFormat } from '@/helper';

export default {

	props: ['category'],
	setup(props) {
		const category_data = ref({})

		//TODO: Add shopping car

		const getProductsByCategory = async (id) => {
			try {
				const { data } = await axios(`/product/getByCategory/${id}`)
				category_data.value = data.products.slice(0, 5)
			} catch (error) {
				console.error(error);
			}
		}
		onMounted(async () => {
			await getProductsByCategory(props.category)
		})

		return {
			category_data,
			price: (price) => moneyFormat(price)
		}
	}
}
</script>
<style lang="scss">
.card-size {
	width: 48%;
}

@media (min-width: 991px) {
	.card-size {
		width: 19%;
	}
}
</style>
