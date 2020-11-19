import {LabeledFaceDescriptors} from "face-api.js";

export default class AuthorizedPerson {

    constructor({name, descriptor, authorizedGuests}) {
        this.name = name;
        this.descriptor = new Float32Array(descriptor);
        this.authorizedGuests = authorizedGuests;
    }
    static generateLabeledFaceDescriptors(authorizedPersons) {
        const res = [];
        if (authorizedPersons && Array.isArray(authorizedPersons)) {
            for (const authorizedPerson of authorizedPersons) {
                if (authorizedPerson instanceof AuthorizedPerson) {
                    res.push(new LabeledFaceDescriptors(authorizedPerson.name, [authorizedPerson.descriptor]));
                }
            }
        }
        return res;
    }
    static parsResidence(data){
        console.log(data);
        const result = [];
        for (const residen of data){
            result.push(new AuthorizedPerson({name : residen.Name ,descriptor: JSON.parse(residen.Data) }))
        }
        return result;
    }
}
