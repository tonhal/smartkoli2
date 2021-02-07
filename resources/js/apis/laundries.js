export const getLaundries = async () => {

    const response = await axios.get("/laundries");

    return response;
}

export const postLaundry = async (data) => {

    const response = await axios.post("/laundries", { ...data });

    return response;
}

export const deleteLaundry = async (id) => {

    const response = axios.delete(`/laundries/${id}`);

    return response;
}