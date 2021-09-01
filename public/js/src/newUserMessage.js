import { sendingApiConfing, sendData } from "./api.js"
import { renderLastMessages } from "./renderMessage.js"

const dataFromForm = () => {
    const bodyMessage = document.querySelector('#textBody').value

    return {
        "body": bodyMessage,

    }
}

/**
 * create config for the HTTP request
 * @returns {object}
 */
const formToApiConfig = () => sendingApiConfing(dataFromForm(), "POST")

const conversationId = location.pathname.split('/')[2]
const apiRoute = `/api/v1/message/user/conversation/${conversationId}`

const afterResponse = (response) => {
    console.log(response)
    renderLastMessages()
    /* location.reload() */
}

/**
 * handle message form submit event
 * @param {event} evt 
 */
export const addMessage = evt => {
    evt.preventDefault()
    console.log(formToApiConfig())
    sendData(apiRoute, formToApiConfig(), afterResponse)
}

