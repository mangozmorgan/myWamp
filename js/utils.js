
async function  getCommitBehindOrigin(repo,htmlElement){


    let formattedData = new FormData
    formattedData.append('repo',repo)
    const response = await fetch('./myWamp/php/getCommitBehindFromOrigin.php', {
        method: 'POST',
        body: formattedData
    }).then(response => response.text())
    let decodedData = JSON.parse(response)

    htmlElement.parentElement.nextElementSibling.innerHTML += `<p title="Number commits may be push" class="font-bold mr-2" ><i class="fa-solid mr-1 text-green-400  cursor-pointer fa-arrow-up "></i>${decodedData.ahead}</p>`
    htmlElement.parentElement.nextElementSibling.innerHTML += `<p title="Your difference with online repository" class="font-bold mr-2 col-end-7" ><i class="fa-solid cursor-pointer mr-1 text-red-400 fa-arrow-down"></i>${decodedData.behind}</p>`
}

async function  getRepoLocalStatus(repo,htmlElement){


    let formattedData = new FormData
    formattedData.append('repo',repo)
    const response = await fetch('./myWamp/php/getLocalRepoStatus.php', {
        method: 'POST',
        body: formattedData
    }).then(response => response.text())
    let decodedData = JSON.parse(response)

    htmlElement.parentElement.nextElementSibling.innerHTML += `<p title="number of changes in your project may be commit" class="font-bold mr-2"><i class="fa-solid mr-1 cursor-pointer text-blue-400 fa-angles-up"></i>${decodedData.commitsToDo}</p>`
}

// document.querySelector('#container').scrollTop = 520;

window.addEventListener('load', ()=>{
    document.querySelectorAll('.nameProjet').forEach( project =>{

        let buttonDivNb = project.parentElement.parentElement.nextElementSibling.nextElementSibling.nextElementSibling.lastElementChild.childElementCount
        if( buttonDivNb === 3 ){
            getRepoLocalStatus(project.textContent.trim(),project).then(function(){
                getCommitBehindOrigin(project.textContent.trim(),project)

            })
        }
    })
})

async function openGitInfo(){

    if(!document.querySelector('#modalInfos').classList.contains('hidden')){
        document.querySelector('#modalInfos').classList.add('hidden')
    }

    if ( document.querySelector('#modalGit').classList.contains('hidden')){

        const response = await fetch('./myWamp/php/getUserGitInfos.php', {
            method: 'GET'
        })
            .then(response => response.text())
        let infosDecoded = JSON.parse(response)

        document.querySelector('#publicRepo').innerHTML = "<span class='font-bold'>Publics repos : </span>"+ infosDecoded.public_repos
        document.querySelector('#privateRepo').innerHTML = "<span class='font-bold'>Privates repos : </span>"+ infosDecoded.total_private_repos
        document.querySelector('#avatarGit').src = infosDecoded.avatar_url

    }

    document.querySelector('#modalGit').classList.toggle('hidden')


}




let triProjet = (value) =>{

    document.querySelectorAll('.nameProjet').forEach(projet =>{
        if ( !projet.textContent.toLowerCase().includes(value.toLowerCase()) ){
            projet.parentElement.parentElement.parentElement.classList.add('hidden')
        }else{
            projet.parentElement.parentElement.parentElement.classList.remove('hidden')
        }
    })
}
document.querySelector('#search').addEventListener('keyup',(e)=>{
    triProjet(e.target.value)

})
document.querySelector('#searchExtension').addEventListener('keyup',(e)=>{
    document.querySelectorAll('.liExt').forEach(element => {
        if( !element.textContent.toLowerCase().includes(e.target.value) ){
            element.classList.add('hidden')
        }else{
            element.classList.remove('hidden')
        }
    })

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
let remove = (nameDirectory, asGitRepository) =>{

    // console.log(element)
    let gitText = ''
    let gitButton = false
    let gitSuccessText = "This project is removed successfully"

    console.log(asGitRepository)

    if ( asGitRepository == 1 ){
        gitText = 'By the way you can also remove the repository GitHub linked to this project'
        gitButton = true
        gitSuccessText = "This project and your repository in Github are removed successfully"

    }

    let colorBG = 'white'
    let textColor = 'black'
    if ( document.querySelector('#default-toggle').checked === true ){
        colorBG = 'rgb(18,25,36)'
        textColor = 'white'
    }
    Swal.fire({
        icon : 'warning',
        width:'40%',
        background : colorBG ,
        title:`<h5 style='color:${textColor}'>Remove a project</h5>`,
        html: `<div class="swal2-html-container " id="swal2-html-container" style="display: block;color: ${textColor}" >Do you want to remove this project ? Think carefully because the deletion is permanent ! ${gitText}</div> `,
        showCancelButton : true,
        confirmButtonColor :'blue',
        confirmButtonText : 'Remove my project',
        CancelButtonText : 'cancel',
        showDenyButton: gitButton,
        denyButtonText: `Remove my project and my Git repository`,
        denyButtonColor: `#9334EA`,

        customClass: {
            title: '' //insert class here
        }

    }).then(async (res) =>{

        if( res.isDenied ){
            let formattedData = new FormData;
            formattedData.append('directory',nameDirectory)

            const response = await fetch('./myWamp/php/removeGitRepository.php', {
                method: 'POST',
                body: formattedData
            })
            res.isConfirmed = true

        }

        if ( res.isConfirmed){

            let formattedData = new FormData;
            formattedData.append('directory',nameDirectory)
            formattedData.append('asGit',asGitRepository)

            const response = await fetch('./myWamp/php/removeProject.php', {
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
                    html: `<div class="swal2-html-container " id="swal2-html-container" style="display: block;color: ${textColor}" >${gitSuccessText} !</div> `,
                }).then(function(){
                    window.location.reload(true);
                })
            }else{
                Swal.fire({
                    icon:'error',
                    background : colorBG ,
                    title:`<h5 style='color:${textColor}'>Remove a project</h5>`,
                    html: `<div class="swal2-html-container " id="swal2-html-container" style="display: block;color: ${textColor}" >Error during the supression of the project</div> `,
                }).then(function(){
                    window.location.reload(true);
                })
            }

        }

    })
}

//DOC : THEMES
//////////////////////////////////////////////////
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

//////////////////////////////////////////////////////

let createProject = (git) => {

    let elementVisibility = ''
    let title ="Create a new project"
    let messSuccess = 'is created successfully !'


    if ( git === true ){
        elementVisibility = '<div class="flex flex-col items-center rounded-lg "><label>Visibility</label><select class="border-2 border-gray-300 w-1/3 h-10 px-5 pr-16 rounded-lg text-sm m-2 themeBG themeTEXT themeBORDER" id="selectVisibility"><option value="public" selected>Public</option><option value="private">Private</option></select></div>'

        title = "Create a new project and GitHub repository<i  class=' fa-brands fa-github cursor-pointer ml-2 toWhite'></i>"

        messSuccess = 'and the GitHub repository are created successfully !'
    }

    let nameProject = ''

    Swal.fire({
        title:title,
        html:
            '<div class="mb-2">A directory will be created in your localhost folder</div> <input id="nameOfProject" placeholder="A name for your project" class="border-2 border-gray-300 h-10 px-5 pr-16 rounded-lg text-sm m-2 themeBG themeTEXT themeBORDER">'+elementVisibility+'<textarea id="description" rows="4" class="block p-2.5 w-full text-sm rounded-lg border border-gray-300" placeholder="Your message..."></textarea>',
        showCancelButton: true,
        confirmButtonText: 'Create a new project',
        showLoaderOnConfirm: true,
        preConfirm: async function () {

            nameProject = document.querySelector('#nameOfProject').value
            let nameOfProject = document.querySelector('#nameOfProject').value
            let description = document.querySelector('#description').value
            let formattedData = new FormData
            formattedData.append('directoryName',nameOfProject)
            formattedData.append('description',description)
            formattedData.append('git',git)

            if ( git === true ){
                let visibility = document.querySelector('#selectVisibility').value
                formattedData.append('visibility',visibility)
            }
            const response = await fetch('./myWamp/php/createProject.php', {
                method: 'POST',
                body: formattedData
            }).then(response =>response.text())
            let resDecoded = JSON.parse(response)

                if ( Object.keys(resDecoded)[0].toString() === 'error'){
                    Swal.fire({
                        icon:'error',
                        title:'Create a new project',
                        text : resDecoded.error,

                    }).then(function(){
                        return false;
                    })
                }else{
                    if( git === true ){
                        const res =  fetch('./myWamp/php/cloneRepo.php', {
                            method: 'POST',
                            body: formattedData
                        })
                    }
                    Swal.fire({
                        icon:'success',
                        title:title,
                        text : "The project "+nameProject+" "+messSuccess,

                    }).then(function(){

                        window.location.reload(true);
                        return false;
                    })
                }
            return true
        },
        allowOutsideClick: false
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

let openInfo = () => {
    if(!document.querySelector('#modalGit').classList.contains('hidden')){
        document.querySelector('#modalGit').classList.add('hidden')
    }
    if ( document.querySelector("#modalInfos").classList.contains('hidden') ){
        document.querySelector("#modalInfos").classList.remove('hidden')

    }else{
        document.querySelector("#modalInfos").classList.add('hidden')

    }
}

let openList = (elementClicked) => {

    if( document.querySelector('#ulExt').classList.contains('fa-caret-up') ){
        document.querySelector('#ulExt').classList.remove('fa-caret-up')
        document.querySelector('#ulExt').classList.add('fa-caret-down')
    }else{
        document.querySelector('#ulExt').classList.remove('fa-caret-down')
        document.querySelector('#ulExt').classList.add('fa-caret-up')
    }

    elementClicked.nextElementSibling.classList.toggle('hidden')
}