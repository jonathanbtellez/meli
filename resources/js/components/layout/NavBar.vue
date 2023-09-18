<template>
	<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
		<div class="container">
			<div>
				<a class="navbar-brand" href='/'>
					Meli
				</a>
			</div>
			<div v-if="user" class="col-12 mb-2 col-md-4 mb-md-0">
				<v-select :options="products" label="name" v-model="product" :reduce="product => product.id" placeholder="What are you looking for"
					:clearable="false" ></v-select>
			</div>
			<div>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse"
					data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
					aria-label="{{ __('Toggle navigation') }}">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<!-- Left Side Of Navbar -->
					<ul class="navbar-nav me-auto">
					</ul>

					<!-- Right Side Of Navbar -->
					<ul class="navbar-nav ms-auto">
						<!-- Authentication Links -->
						<template v-if="!user">
							<li class="nav-item me-2">
								<a class="btn btn-primary" href='login'>Login</a>
							</li>
							<li class="nav-item">
								<a class="btn btn-secondary" href='register'>Register</a>
							</li>
						</template>
						<template v-else>
							<li class="nav-item dropdown">
								<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
									data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									{{ user.full_name }}{{ ' ' }}
								</a>
								<div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
									<!-- <a class="dropdown-item" href='logout' onclick="event.preventDefault();
															 document.getElementById('logout-form').submit();">
										{{ __('Logout') }}
									</a> -->
									<a class="dropdown-item" @click="logOut">
										Logout
									</a>

									<!-- <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
										@csrf
									</form> -->
								</div>
							</li>
						</template>
					</ul>
				</div>
			</div>
		</div>
	</nav>
</template>
<script>
import { ref, watch } from 'vue';
export default {
	props: ['user', 'products'],
	setup(props) {

		const product = ref({})

		watch(product, (newValue, oldValue) => {
			console.log(newValue);
			//TODO: Redirect to product page
		})

		const logOut = async () => {
			try {
				await axios.post('/logout', props.user)
				window.location.href = '/login'
			} catch (error) {
				console.log(error);
			}
		}

		return {
			product,
			logOut,
		}
	}
}
</script>
<style scope>
	placeholder{
		color: #000;
	}
</style>
