export const getGuests = async () => {

    const response = await axios.get("/guests");

    return response;
}

export const postGuest = async (data) => {

    const response = await axios.post("/guests", { ...data });

    return response;
}

export const deleteGuest = async (id) => {

    const response = await axios.delete(`guests/${id}`);

    return response;
}