import './bootstrap';


let addressInput = document.getElementById('address');

addressInput.addEventListener ('input', function() {
    let ulElement = document.getElementById('searchResults');
    ulElement.classList.remove('d-none');
    // ulElement.classList.add('d-none');
    if (this.value === '') ulElement.classList.add('d-none');
    const inputValue = this.value.replace(" ", "+");
    ulElement.innerHTML = '';
    const apiKey='9B3Txp0d4DICteHUwWohHtaZOMm3WCUY';
    let coordinate = `https://api.tomtom.com/search/2/search/${inputValue}.json?key=${apiKey}&countrySet=IT`;
        
    async function file_get_contents(uri, callback) {
        let res = await fetch(uri),
            ret = await res.text(); 
        return callback ? callback(ret) : ret; // a Promise() actually.
    }
    let result = '';
    file_get_contents(coordinate).then((response) => {
        result = JSON.parse(response)
        // console.log(result)
        for (let i = 0; i < 4; i++) {
            const li = document.createElement('li');
            li.textContent = result.results[i].address.freeformAddress;
            li.classList.add('resultItem');
            li.addEventListener('click',() => {
                this.value =  result.results[i].address.freeformAddress;
                console.log(this)
                
                ulElement = document.getElementById('searchResults');
                ulElement.innerHTML = '';
                ulElement.classList.add('d-none')
            })
            ulElement.appendChild(li);
        }
        // result.results.forEach(element => {
        //     // console.log(element.address);
        //     const li = document.createElement('li');
        //     li.classList.add('resultItem');
        //     li.textContent = element.address.freeformAddress;
        //     li.addEventListener('click',() => {
        //         this.value =  element.address.freeformAddress;
                
        //         ulElement = document.getElementById('searchResults');
        //         ulElement.innerHTML = '';
        //         ulElement.classList.add('d-none')
        //     })
        //     ulElement.appendChild(li);
        // });
    });
})
