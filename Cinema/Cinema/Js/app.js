var swiper=new Swiper(".swiper",{
    effect:"coverflow",
    grabCursor:true,
    centeredSlides:true,
    initialSlide:true,
    speed:600,
    preventClicks:true,
    slidesPerView:"auto",
    coverflowEffect:{
        rotate:0,
        stretch:30,
        depth:350,
        modifier:1,
        slideShadows:true,
        
    },
    on:{
        click(event){
            swiper.slideTo(this.clickedIndex);
        
        },
    },
    pagination:{
        el:".swiper-pagination",
    },
    
});