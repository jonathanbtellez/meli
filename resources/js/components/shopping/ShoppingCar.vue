<template>
	<nav-bar :products="products" :user="user" title="Shopping car" />
	<main-banner />
	<section class="container">
		<h2 class="fs-4 text-center">Selected products</h2>
		<div class="row">
			<div class="col-12 col-md-8">

				<template v-if="!products_quantity">
					<div class="bg-white border rounded p-4 h-75 align-items-center text-center">
						<p class="w-100">There is no products to buy yet, please choice someones</p>
						<a href="/" class="btn btn-secondary">Go home</a>
					</div>
				</template>
				<template v-else>
					<div v-for="product in products_data" :key="product.id" class="bg-white border rounded mb-2 p-3">
						<div class="w-full m-2 me-0 mt-0 text-end">
							<button class="btn btn-danger btn-sm" @click="handle_delete(product.id)"><i
									class="fa-solid fa-trash"></i></button>
						</div>
						<div class="row">
							<div class="pb-3 col-md-4 d-flex align-items-center">
								<img :src="product.image.url" alt="image product" class="w-100">
							</div>
							<div class=" align-items-center col-md-8 d-md-flex justify-content-around">
								<div>
									<h2 class="fw-bold fs-5">Name:
										<span class="fw-normal">{{ product.name }}</span>
									</h2>
									<p class="fw-bold">Price:
										<span class="fw-normal">{{ price(product.price) }}</span>
									</p>
								</div>
								<div class="d-flex align-items-baseline justify-content-center">
									<button class="btn btn-secondary btn-sm me-4" @click="handle_decrement(product.id)"><i
											class="fa-solid fa-minus"></i></button>
									<span class="fw-bold">{{ product.quantity }}</span>
									<button class="btn btn-secondary btn-sm ms-4" @click="handle_increment(product.id)"><i
											class="fa-solid fa-plus"></i></button>
								</div>
							</div>
						</div>
					</div>
				</template>
			</div>
			<div class="col-12 col-md-4 mb-3">
				<div class="p-3 bg-white rounder border">
					<p class="fw-bold">Total products:
						<span class="fw-normal">{{ products_quantity }}</span>
					</p>
					<p class="fw-bold">Total:
						<span class="fw-normal">{{ price(total) }}</span>
					</p>
					<button class="btn btn-primary" @click="handle_buy" :disabled="!products_quantity">Buy now</button>
				</div>
			</div>
		</div>
	</section>
	<v-footer />
</template>
<script>
import ProductList from '../product/ProductList.vue';
import useLocalStorage from '@/composables/useLocalStorage';
import { onMounted, ref } from 'vue';
import { moneyFormat } from '@/helper';
import useShoppingCart from '@/composables/useShoppingCart';
import useToast from '@/composables/useToast'
export default {
	components: {
		ProductList
	},
	props: ['user', 'products', 'categories'],
	setup(props) {
		const { getStorage, removeStorage } = useLocalStorage()
		const { add_product, remove_product, delete_item } = useShoppingCart()
		const { openToast, openFunctionToast } = useToast()

		const products_to_save = ref();
		const products_data = ref()
		const total = ref(0)
		const products_quantity = ref()

		/**
		 * brings the info save in the localStorage
		 * then create a new list with the info of the product an the quantity selected
		 */
		const getProductsInfo = () => {
			products_to_save.value = getStorage('car')
			if (!products_to_save.value) return
			products_data.value = products_to_save.value.map(product => {
				const productInfo = { ...props.products.find(prod => prod.id === product.product_id), quantity: product.quantity }
				return productInfo
			})
		}

		/**
		 * Obtain the total of products selected, also get the total price of the purchase
		 */
		const calculateTotal = () => {
			products_quantity.value = products_data.value.reduce((total, product) => total + product.quantity, 0)
			total.value = products_data.value.reduce((total, product) => total + (product.quantity * product.price), 0)
		}

		/**
		 * Add a new product refresh the product and the total
		  */
		const handle_increment = (id) => {
			const user = getStorage('user')
			add_product(id, user.id)
			getProductsInfo()
			calculateTotal()
		}
		/**
		 * Remove a  product refresh the product and the total
		*/
		const handle_decrement = (id) => {
			remove_product(id)
			getProductsInfo()
			calculateTotal()
		}

		/**
		 * Delete a item of products list then refresh the products and the total
		 */
		const handle_delete = (id) => {
			delete_item(id)
			getProductsInfo()
			calculateTotal()
			openToast('Item deleted', 'error')
		}

		/**
		 * Verify that each product has at least one item, Save the buy in the DB
		 * show a toast message to confirm to the user and remove the list of the storage
		 */
		const handle_buy = async () => {
			products_to_save.value = products_to_save.value.filter(product => product.quantity !== 0)
			try {
				await axios.post('/shopping', {
					products: products_to_save.value
				})
				openFunctionToast('Your purchase was saved', 'success', () => window.location.href = '/')
				removeStorage('car')
			} catch (error) {
				console.error(error);
			}
		}

		onMounted(() => {
			getProductsInfo()
			calculateTotal()
		})



		return {
			handle_buy,
			handle_decrement,
			handle_delete,
			handle_increment,
			price: (price) => moneyFormat(price),
			products_data,
			products_quantity,
			total,
		}
	}
}
</script>
