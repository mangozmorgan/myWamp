// window.addEventListener('load', (event) => {
//     document.querySelector('#default-toggle').click()
// });


let triProjet = (value) =>{

    document.querySelectorAll('.nameProjet').forEach(projet =>{
        if ( !projet.textContent.toLowerCase().includes(value.toLowerCase()) ){
            projet.parentElement.parentElement.classList.add('hidden')
        }else{
            projet.parentElement.parentElement.classList.remove('hidden')
        }
    })
}
document.querySelector('#search').addEventListener('keyup',(e)=>{
    triProjet(e.target.value)

})

document.querySelector('#btnSearch').addEventListener('click',()=>{
    document.querySelector('#search').value = ''
    triProjet("")
})

let openExplorer =async (path) =>{

    let formattedData = new FormData
    formattedData.append('directory',path)
    const response = await fetch('./myWamp/openFolder.php', {
        method: 'POST',
        body: formattedData
    })
}

let openGit = (uri) =>{
    window.location.href = uri
}
let remove = (nameDirectory) =>{

    let colorBG = 'white'
    let textColor = 'black'
    if ( document.querySelector('#default-toggle').checked === true ){
        colorBG = 'rgb(18,25,36)'
        textColor = 'white'
    }
    Swal.fire({
        icon : 'warning',
        background : colorBG ,
        title:`<h5 style='color:${textColor}'>Remove a project</h5>`,
        html: `<div class="swal2-html-container " id="swal2-html-container" style="display: block;color: ${textColor}" >Do you want to remove this project ? Think carefully because the deletion is permanent !</div> `,
        showCancelButton : true,
        CancelButtonText : 'cancel',
        customClass: {
            title: '' //insert class here
        }

    }).then(async (res) =>{

        if ( res.isConfirmed){

            let formattedData = new FormData;
            formattedData.append('directory',nameDirectory)

            const response = await fetch('./myWamp/removeProject.php', {
                method: 'POST',
                body: formattedData
            })
                .then(response => response.text())
            console.log(response)
            if(response == 1 ){
                Swal.fire({
                    icon:'success',
                    background : colorBG ,
                    title:`<h5 style='color:${textColor}'>Remove a project</h5>`,
                    html: `<div class="swal2-html-container " id="swal2-html-container" style="display: block;color: ${textColor}" >This project is removed with success</div> `,
                }).then(function(){
                    location.reload()
                })
            }else{
                Swal.fire({
                    icon:'error',
                    background : colorBG ,
                    title:`<h5 style='color:${textColor}'>Remove a project</h5>`,
                    html: `<div class="swal2-html-container " id="swal2-html-container" style="display: block;color: ${textColor}" >Error during the supression of the project</div> `,
                }).then(function(){
                    location.reload()
                })
            }

            // window.location.reload()
        }

    })
}

let goDark = () => {
    document.querySelectorAll('.themeBG').forEach(element =>{
        element.classList.add('bg-slate-800')
    })
    document.querySelectorAll('.themeTEXT').forEach(element =>{
        element.classList.remove('text-gray-700')
        element.classList.add('text-white')
    })
    document.querySelectorAll('.themeBORDER').forEach(element =>{
        element.classList.remove('shadow')
        element.classList.add('border')
        element.classList.add('border-slate-500')
    })
}
let goNormal = () => {
    document.querySelectorAll('.themeBG').forEach(element =>{
        element.classList.remove('bg-slate-800')
    })
    document.querySelectorAll('.themeTEXT').forEach(element =>{
        element.classList.remove('text-white')
        element.classList.add('text-gray-700')
    })
    document.querySelectorAll('.themeBORDER').forEach(element =>{
        element.classList.add('shadow')
        element.classList.remove('border')
        element.classList.remove('border-slate-500')
    })
}

document.querySelector('#default-toggle').addEventListener('click',(e)=>{
    let formData = new FormData
    formData.append('method','changeTheme')
    const response =  fetch(`./myWamp/php/writeInFile.php`,{
        method: 'POST',
        body : formData
    })


    if ( e.target.checked === true ){
       goDark()
    }else{
        goNormal()
    }
})


if( config.theme === 'dark'){
    goDark()
    document.querySelector('#default-toggle').setAttribute('checked','checked')
}else{
    goNormal()
    document.querySelector('#default-toggle').removeAttribute('checked')
}