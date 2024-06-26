import { Pagination, User } from "@/types/users.interface";
import axios from "axios";

export default class UserUtils {
    /**
     *
     * @param value The search term (string | number)
     * @returns A promise that resolves to an AxiosResponse object containing the result
     */
    static async searchUser(value: string | number): Promise<User[]> {
        try {
            const response = await axios.post("/users/search", {
                value,
            });
            if (response.status !== 200) {
                throw new Error(response.statusText);
            }
            return response.data;
        } catch (error) {
            console.error("Error fetching users", error);
            throw error;
        }
    }

    static async index(): Promise<Pagination<User[]>> {
        try {
            const response = await axios.post("/users/index");
            if (response.status !== 200) {
                throw new Error(response.statusText);
            }
            return response.data;
        } catch (error) {
            console.error("Error fetching users", error);
            throw error;
        }
    }
}
