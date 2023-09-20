<template>
	<nav-bar :products="products" :user="user" title="Shopping car" />
	<main-banner />
	<section class="container">
		<h2 class="fs-4 text-center">Selected products</h2>
		<div class="row">
			<div class="col-12 col-md-8">
				<div v-for="product in products_data" :key="product.id" class="bg-white border rounded mb-2">
					<div class="w-full m-2 m-md-0 mt-md-1 me-md-1 text-end">
						<button class="btn btn-danger btn-sm" @click="handle_delete(product.id)"><i class="fa-solid fa-trash"></i></button>
					</div>
					<div class="d-md-flex flex-row justify-content-between align-items-center gap-2 p-3">
						<div class="image-container pb-3">
							<img :src="product.image.url" alt="image product" class="w-100">
						</div>
						<div>
							<h2 class="fw-bold fs-5">Name:
								<span class="fw-normal">{{ product.name }}</span>
							</h2>
							<p class="fw-bold">Price:
								<span class="fw-normal">{{ price(product.price) }}</span>
							</p>
						</div>
						<div class="d-flex align-items-baseline justify-content-center">
							<button class="btn btn-secondary btn-sm me-4" @click="handle_decrement(product.id)"><i class="fa-solid fa-minus"></i></button>
							<span class="fw-bold">{{ product.quantity }}</span>
							<button class="btn btn-secondary btn-sm ms-4" @click="handle_increment(product.id)"><i
									class="fa-solid fa-plus"></i></button>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-4 mb-3">
				<div class="p-3 bg-white rounder border">
					<p class="fw-bold">Total products:
						<span class="fw-normal">{{ products_quantity }}</span>
					</p>
					<p class="fw-bold">Total:
						<span class="fw-normal">{{ price(total) }}</span>
					</p>
					<button class="btn btn-primary" @click="handle_buy">Buy now</button>
				</div>
			</div>
		</div>
	</section>
</template>
<script>
import ProductList from '../product/ProductList.vue';
import useLocalStorage from '@/composables/useLocalStorage';
import { onMounted, ref } from 'vue';
import { moneyFormat } from '@/helper';
import useShoppingCart from '@/composables/useShoppingCart';
export default {
	components: {
		ProductList
	},
	props: ['user', 'products', 'categories'],
	setup(props) {
		const { getStorage } = useLocalStorage()
		const { add_product, remove_product, delete_item } = useShoppingCart()

		const products_to_save = ref();
		const products_data = ref()
		const total = ref(0)
		const products_quantity = ref()

		const getProductsInfo = () => {
			products_to_save.value = getStorage('car')
			products_data.value = products_to_save.value.map(product => {
				const productInfo = { ...props.products.find(prod => prod.id === product.product_id), quantity: product.quantity }
				return productInfo
			})
		}

		const calculateTotal = () => {
			products_quantity.value = products_data.value.reduce((total, product) => total + product.quantity, 0)
			total.value = products_data.value.reduce((total, product) => total + (product.quantity * product.price), 0)
		}

		const handle_increment = (id) => {
			const user = getStorage('user')
			add_product(id, user.id)
			getProductsInfo()
			calculateTotal()
		}
		const handle_decrement = (id) => {
			remove_product(id)
			getProductsInfo()
			calculateTotal()
		}
		const handle_delete = (id) => {
			delete_item(id)
			getProductsInfo()
			calculateTotal()
		}
		const handle_buy = async () => {
			try {
				await axios.post('/shopping',{
					products : products_to_save.value
				})
				console.log('save');
			} catch (error) {
				console.error(error);
			}
		}

		onMounted(() => {
			getProductsInfo()
			calculateTotal()
		})



		return {
			price: (price) => moneyFormat(price),
			products_quantity,
			products_data,
			total,
			go_to_category: (id) => window.location.href = `/category/get-products/${id}`,
			handle_increment,
			handle_decrement,
			handle_delete,
			handle_buy
		}
	}
}
</script>
<style lang="scss" scoped>
.image-container {
	width: 40%;
	margin: auto;
}

@media (min-width: 768px) {
	.image-container {
		width: 30%;
	}
}

@media (min-width: 1024) {
	.image-container {
		width: 25%;
	}
}
</style>