import { addMessage } from './src/newUserMessage.js'
import { renderAllMessage, renderLastMessages } from './src/renderMessage.js'

document.addEventListener("DOMContentLoaded", () => {
    renderAllMessage()
})

setInterval(function(){ renderLastMessages() }, 15000)

const addMessageForm = document.querySelector('#addMessage')
addMessageForm.addEventListener('submit', addMessage)
