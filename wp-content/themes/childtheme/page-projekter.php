<?php
/**
 * The template for displaying loop view
 */

get_header(); 

?>

<?php if ( ( is_page() && ! inspiro_is_frontpage() ) && ! has_post_thumbnail( get_queried_object_id() ) ) : ?>

<div class="inner-wrap">
	<div id="primary" class="content-area">

<?php endif ?>

		<main id="main" class="site-main" role="main">

		<nav id="filtrering">
		<div id="drop-down">
	<button data-projekter="alle">Verdensmål</button>
	<button data-klassetrin="klassetrin">Klassetrin</button>
	<button data-fag="klassetrin">Fag</button>
		</nav>

		<section class="projekt-oversigt"></section>

		</main><!-- #main -->
 
<template id="mytemplate">
	<article>
		<h2 class="overskrift"></h2>
		<img class="hovedbillede" src="" alt=""/>
		<p class="kort_beskrivelse"></p>
	<!-- 	<p class="lang_beskrivelse"></p> -->
</article>
</template> 

<?php if ( ( is_page() && ! inspiro_is_frontpage() ) && ! has_post_thumbnail( get_queried_object_id() ) ) : ?>

	</div><!-- #primary -->
</div><!-- .inner-wrap -->

<?php endif ?>

<script>
	let projekter; 
	let klasse;
	let verdensml;
	let filterklassetrin = "alle";
	/* let filterProjekt = "alle";  */
	const liste = document.querySelector(".projekt-oversigt");
	const skabelon = document.querySelector("#mytemplate");

document.addEventListener("DOMContentLoaded", getJson);



const url = "https://sarakondrup.dk/unesco/wordpress/wp-json/wp/v2/projekter/?per_page=100";
const verdensmlUrl = "https://sarakondrup.dk/unesco/wordpress/wp-json/wp/v2/verdensml/?per_page=100"; 
const klasseUrl = "https://sarakondrup.dk/unesco/wordpress/wp-json/wp/v2/klasse";


async function getJson() {
	
	let response = await fetch(url);
	let verdensml = await fetch(verdensmlUrl);
	let klasse = await fetch(klasseUrl)
	let klasseResponse = await fetch(klasseUrl);
	projekter = await response.json();
	console.log(klasse + "liste");
	console.log(projekter)
	visProjekter();

document.querySelector("#filtrering").addEventListener("click", opretKnapper)
}

function opretKnapper() {
	
	klasse.forEach(klasse=> {
		document.querySelector("#filter").innerHTML += `<button class="filterKnapper" data-klassetrinnet="${klasse.id}">${klasse.name}</button>`
	});


	addEventListenersToButtons();

}

function addEventListenersToButtons() {
document.querySelectorAll("#filter button").forEach(elm => {elm.addEventListener("click", filtrering);

})
};


function filtrering() {
filterklassetrin = this.dataset.klassetrinnet;
console.log(filterklassetrin);

visProjekter();

}


function visProjekter() {
	
	console.log(projekter);
	
		liste.innerHTML="";
    	projekter.forEach(projekt => {
        let klon = skabelon.cloneNode(true).content;
		klon.querySelector(".overskrift").textContent = projekt.title.rendered;
		klon.querySelector(".hovedbillede").src = projekt.hovedbillede.guid;
        klon.querySelector(".kort_beskrivelse").innerHTML = projekt.kort_beskrivelse;
	/* 	klon.querySelector(".lang_beskrivelse").innerHTML = projekt.lang_beskrivelse; */
		klon.querySelector("article").addEventListener("click", ()=>{location.href = projekt.link;})
		liste.appendChild(klon);
		})
	}






</script>

<?php
get_footer();
