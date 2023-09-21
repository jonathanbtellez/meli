<template>
	<div class="banner">
	</div>
</template>
<style lang="scss">
.banner {
	width: 100%;
	height: 15vh;
	background-image: url('/storage/project/banner.jpg');
	background-attachment: local;
	background-repeat: no-repeat;
	background-size: contain;
}

@media (min-width: 490px){
	.banner{
		min-height: 25vh;
	}
}

@media (min-width: 768px){
	.banner{
		height: 30vh;
	}
}

@media (min-width: 930px){
	.banner{
		min-height: 40vh;
	}
}

@media (min-width: 1024px) {
	.banner {
		min-height: 50vh;

	}
}

@media (min-width: 1450px) {
	.banner {
		height: 60vh;

	}
}
</style>
